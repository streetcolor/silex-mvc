<?php

namespace Src\UserBundle\Entities;

/**
 * @Entity
 * @Table(name="homes")
 */
class Home
{   
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_home;

    /** @Column(type="string", length=30, unique=false, nullable=false) */
    private $lastname;

   /**
     * Get idHome
     *
     * @return integer
     */
    public function getIdHome()
    {
        return $this->id_home;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Home
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

}
