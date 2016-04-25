<?php
namespace Src\UserBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserValidator extends ConstraintValidator
{


	 private $em;

    public function __construct($em=false, $flag)
    {
        $this->em = $em;   
    }

    public function validate($value, Constraint $constraint)
    {

        $getUser = $this->em->getRepository('\Entities\User')->findOneBy(array('username'=>$value));
        if($getUser){

            $this->context->buildViolation($constraint->message)
                            ->setParameter('%string%', $value)
                            ->addViolation();        
        }

        
    }
}