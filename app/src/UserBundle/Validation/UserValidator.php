<?php

namespace Src\UserBundle\Validation;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolationList;

/**
* User Validator
*/
class UserValidator implements Validator
{
    protected $engine;
    protected $violations;

    /**
     * Constructor
     *
     * @param [type] $engine $app['validator'] aka SF2 component
     * @note: Add Type hinting on $engine
     */
    public function __construct($engine)
    {
        $this->engine = $engine;
        $this->violations = new ConstraintViolationList;
    }

    /**
    * Validates a set of data
    *
    * @param  [type] $data [description]
    * @return [type]       [description]
    * @todo : add Type hint Core\Entities\Gallery $data
    */
    public function validate($data, array $groups = null)
    {
        // 1: Validate our object with groups
        $violations = $this->engine->validate($data, null, $groups );
        
        foreach ($violations as $violation) {
            $this->violations->add($violation);
        }

        return count($this->violations) ? false : true;
    }

    /**
     * Return errors
     *
     * @return [type] [description]
     */
    public function getErrors()
    {
        $errors = [];

        foreach ($this->violations as $violation) {
            $property = ltrim(rtrim($violation->getPropertyPath(), ']'), '[');
            $errors[$property] = $violation->getMessage();
        }

        return $errors;
    }
}
