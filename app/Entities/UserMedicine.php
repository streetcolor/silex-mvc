<?php

namespace Entities;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity
 * @Table(name="users_medicines",uniqueConstraints={@UniqueConstraint(name="unique", columns={"id_medicine", "id_user"})})
 */


class UserMedicine
{   
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_user_medicine;

    /** @Column(type="integer", length=11, unique=false, nullable=false) */
    private $id_medicine;

     /** @Column(type="integer", length=11, unique=false, nullable=false) */
    private $id_user;

    /** @Column(type="integer", length=11,nullable=true) */
    private $number;

    /** @Column(type="date",  nullable=true) */
    private $expiration;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="users_medicines")
     * @JoinColumn(name="id_user", referencedColumnName="id_user")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Medicine", inversedBy="users_medicines")
     * @JoinColumn(name="id_medicine", referencedColumnName="id_medicine")
     */
    private $medicine;
    

    /**
     * Sets Voucher validation constraints
     *
     * @param  ClassMetadata $metadata [description]
     * @return [type]                  [description]
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint(
            'user',
            new Assert\NotBlank()
        );

        $metadata->addPropertyConstraint(
            'medicine',
            new Assert\NotBlank()
        );

        $metadata->addPropertyConstraint(
            'number',
            new Assert\Range([
                'min'        => 1,
                'minMessage' => 'You must enter at least {{ limit }} box'
            ])
        );

        $metadata->addPropertyConstraint(
            'expiration',
            new Assert\Date()
        );

    }

    /**
     * Get idUserMedicine
     *
     * @return integer
     */
    public function getIdUserMedicine()
    {
        return $this->id_user_medicine;
    }

    /**
     * Set idMedicine
     *
     * @param integer $idMedicine
     *
     * @return UserMedicine
     */
    public function setIdMedicine($idMedicine)
    {
        $this->id_medicine = $idMedicine;

        return $this;
    }

    /**
     * Get idMedicine
     *
     * @return integer
     */
    public function getIdMedicine()
    {
        return $this->id_medicine;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return UserMedicine
     */
    public function setIdUser($idUser)
    {
        $this->id_user = $idUser;

        return $this;
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
     * Set user
     *
     * @param \Entities\User $user
     *
     * @return UserMedicine
     */
    public function setUser(\Entities\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Entities\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set medicine
     *
     * @param \Entities\Medicine $medicine
     *
     * @return UserMedicine
     */
    public function setMedicine(\Entities\Medicine $medicine = null)
    {
        $this->medicine = $medicine;

        return $this;
    }

    /**
     * Get medicine
     *
     * @return \Entities\Medicine
     */
    public function getMedicine()
    {
        return $this->medicine;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return UserMedicine
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     *
     * @return UserMedicine
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    public function serialize(){
        return get_object_vars($this);
    }
}
