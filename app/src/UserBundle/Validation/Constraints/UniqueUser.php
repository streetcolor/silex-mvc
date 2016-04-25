<?php
namespace Src\UserBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;

/**
*
*/
class UniqueUser extends Constraint
{
    public $message = ' "%string%" is already registerd';

    public function validatedBy()
    {
        return 'validator.uniqueUser';

    }
}
