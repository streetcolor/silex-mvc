<?php

namespace Src\UserBundle\Controller;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Silex\Provider\ValidatorServiceProvider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Core\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Deafault controller
 *
 * @package default
 */
class UserController extends Controller
{

    public function getSignUp(Request $request){

        $encoder = new MessageDigestPasswordEncoder();

        $errors_signin = [];
        $error_login = false;
        $user = new \Entities\User();

        $data = $request->request->all();
        
        if($data){

            $validator = $this->app['user.validator'];
            $encoder = new MessageDigestPasswordEncoder();

            $password = ($data['password']) ? $encoder->encodePassword($data['password'], '') : false;
            $user->setLastname($data['lastname']);
            $user->setFirstname($data['firstname']);
            $user->setUsername($data['username']);
            $user->setPassword($password);
            
            if (!$validator->validate($user, ['insert'])) {
                $errors_signin = $validator->getErrors();
            }
            else{

            
                $this->app['orm.em']->persist($user);
                $this->app['orm.em']->flush();    
                
                $User  = new \Symfony\Component\Security\Core\User\User($data['username'], $password, array('ROLE_USER'));
                $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken($User, $User->getPassword(), 'secured', array('ROLE_USER'));
               
                

                $this->app['security.token_storage']->setToken($token);

                return $this->app->redirect('/account');

            }
        }
        else{

            $token = $this->app['security.token_storage']->getToken();
            if($this->app['security.authorization_checker']->isGranted('ROLE_USER')){
                if (null !== $token) {
                    $user = $token->getUser()->getUsername();
                }
        
            }

           $error_login = $this->app['security.last_error']($this->request);
  
        }
        return  $this->app['twig']->render(
                    'UserBundle/View/signup.twig', 
                    array(
                        'errors_signin'=>$errors_signin, 
                        'error_login'=>$error_login
                    ));

    }
}
