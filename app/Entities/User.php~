<?php

namespace Entities;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{   
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_user;

    /** @Column(type="string", length=30, unique=false, nullable=false) */
    private $lastname;

    /** @Column(type="string", length=30, unique=false, nullable=false) */
    private $firstname;
    
    /** @Column(type="string", length=255, unique=true, nullable=false) */
    private $username;

    /** @Column(type="string", length=255, unique=false, nullable=false) */
    private $password;
    
    /**
    * @OneToMany(targetEntity="UserMedicine", mappedBy="user", cascade={"persist"})
    */
    private $users_medicines;


    /**
     * Sets Voucher validation constraints
     *
     * @param  ClassMetadata $metadata [description]
     * @return [type]                  [description]
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {

        $metadata->addPropertyConstraint(
            'firstname',
            new Assert\NotBlank(['groups' => 'insert'])
        );

        $metadata->addPropertyConstraint(
            'lastname',
            new Assert\NotBlank(['groups' => 'insert'])
        );

        $metadata->addPropertyConstraint(
            'password',
            new Assert\NotBlank(['groups' => 'insert'])
        );
        $metadata->addPropertyConstraint('password', new Assert\Length(array(
            'min'        => 8,
            'max'        => 20,
            'minMessage' => 'Your reference must be at least {{ limit }} characters long',
            'maxMessage' => 'Your reference cannot be longer than {{ limit }} characters',
        )));

        $metadata->addPropertyConstraint(
            'username',
            new Assert\NotBlank(['groups' => 'insert'])
        );

         $metadata->addPropertyConstraint(
            'username',
            new  \Src\UserBundle\Validation\Constraints\UniqueUser([
                'groups' => 'insert'
            ])
        );

    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users_medicines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
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

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add usersMedicine
     *
     * @param \Entities\UserMedicine $usersMedicine
     *
     * @return User
     */
    public function addUsersMedicine(\Entities\UserMedicine $usersMedicine)
    {
        $this->users_medicines[] = $usersMedicine;

        return $this;
    }

    /**
     * Remove usersMedicine
     *
     * @param \Entities\UserMedicine $usersMedicine
     */
    public function removeUsersMedicine(\Entities\UserMedicine $usersMedicine)
    {
        $this->users_medicines->removeElement($usersMedicine);
    }

    /**
     * Get usersMedicines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsersMedicines()
    {
        return $this->users_medicines;
    }
}
