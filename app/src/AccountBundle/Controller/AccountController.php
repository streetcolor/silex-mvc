<?php

namespace Src\AccountBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Core\Controller;

/**
 * Deafault controller
 *
 * @package Account
 */
class AccountController extends Controller
{

    public function getIndex()
    {	
        $user = $this->app['token.user'];

        return  $this->app['twig']->render('AccountBundle/View/account.html', array(
            'username'      => $this->app['token.user']->getUsername(),
            'medicines'     => $user->getUsersMedicines()
        ));    

    }

    public function ajaxGetMedicines(Request $request){
     	
        $getData = $this->app['orm.em']->getRepository('\Entities\Medicine')->myfindOne($request);

        $posts = $getData->getQuery()->getResult();
        $medicines = [];
       
        foreach ($posts as $key => $medicine) {
            $medicines[] = ['ID'=>$medicine->getIdMedicine(), 'name'=>$medicine->getName()];
        }

        $count = $getData->count();


     	$response = new JsonResponse();
		return $response->setData(
		   $medicines
		);

    }

    public function ajaxPostMedicines(Request $request){
        
        $em =  $this->app['orm.em'];

        $medicine = $em->getRepository('\Entities\Medicine')->findOneBy(array('id_medicine' =>  $request->request->get('id_medicine')));

        $userMedicine = new \Entities\UserMedicine();

        $userMedicine
            ->setUser($this->app['token.user'])
            ->setMedicine($medicine);

        $em->persist($userMedicine);
        $em->flush();

        $response = new JsonResponse();
        return $response->setData(
           $userMedicine
        );

    }

    public function ajaxDeleteMedicines(Request $request){

        $em =  $this->app['orm.em'];
        $response = new JsonResponse();

        $data = array(
                'id_user_medicine' =>  $request->request->get('id_user_medicine'),
                'id_user' =>  $this->app['token.user']->getIdUser()
            );

        $UserMedicine = $em->getRepository('\Entities\UserMedicine')->findOneBy($data);

        $em->remove($UserMedicine);
        
        $em->flush();

        return $response->setData(
           array(
                'status'=>'success',
                'data'=> $data
            )
        );  

    }

    public function ajaxPutUserMedicines(Request $request, $id){
        $response = new JsonResponse();
        $em =  $this->app['orm.em'];

        $data = array(
            'id_user_medicine' =>  $id,
            'id_user' =>  $this->app['token.user']->getIdUser()
        );

        $UserMedicine = $em->getRepository('\Entities\UserMedicine')->findOneBy($data);


        if(!$UserMedicine){
            throw new NotFoundHttpException("Medicine not found");
        }

        $number = $request->request->get('number') ?: NULL;
        $expiration = $request->request->get('expiration') ?: NULL;

        if(null!==$expiration){
             $date = new \DateTime($expiration);
        }

        $UserMedicine
            ->setExpiration($date)
            ->setNumber($number);

        $validator = $this->app['account.validator'];

        if (!$validator->validate($UserMedicine)) {
            $errors = $validator->getErrors();
            return $response->setData(
               ['status'=>'error', 'data'=>$errors]
            );
        }
        else{
            $em->flush();
            return $response->setData(
               ['status'=>'success', 'data'=>$UserMedicine->serialize()]
            );
        }
        
       
        

    }

    public function ajaxGetUserMedicines(Request $request, $id){

        $em =  $this->app['orm.em'];

        $data = array(
            'id_user_medicine' =>  $id,
            'id_user' =>  $this->app['token.user']->getIdUser()
        );

        $UserMedicine = $em->getRepository('\Entities\UserMedicine')->findOneBy($data);

        $data = $UserMedicine->serialize();
        $data['medicine'] = $UserMedicine->getMedicine()->serialize();


        $response = new JsonResponse();
        return $response->setData(
           ['status'=>'success', 'data'=>$data]
        );

    }
       
}
