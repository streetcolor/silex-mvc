<?php

namespace Src\AccountBundle\Entities;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity
  * @Entity(repositoryClass="Src\AccountBundle\Repositories\MedicineRepository")
 * @Table(name="medicines")
 */
class Medicine
{   
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_medicine;

    /** @Column(type="string", length=255, unique=false, nullable=true) */
    private $cis;

    /** @Column(type="string", length=255, unique=true, nullable=false) */
    private $name;
    
    /** @Column(type="string", length=255, unique=false, nullable=false) */
    private $administration;

    /** @Column(type="string", length=255, unique=false, nullable=false) */
    private $autorisation;

    /** @Column(type="string", length=255, unique=false, nullable=false) */
    private $procedure;

    /** @Column(type="string", length=255, unique=false, nullable=false) */
    private $status;

    /** @Column(type="string", length=255, unique=false, nullable=true) */
    private $date_autorisation;

    /** @Column(type="string", length=255, unique=false, nullable=true) */
    private $availability;

    /** @Column(type="string", length=255, unique=false, nullable=true) */
    private $autorisation_number;

    /** @Column(type="string", length=255, unique=false, nullable=false) */
    private $brand;

    /** @Column(type="boolean", length=255, unique=false, nullable=false) */
    private $security;

    /** @Column(type="datetime") */
    private $date_created;

    /** @Column(type="datetime") */
    private $date_updated;

    /**
    * @ManyToMany(targetEntity="\Src\UserBundle\Entities\UserMedicine", inversedBy="users")
    * @JoinTable(name="users_medicines")
    */    
    private $users_medicines;

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
     * Set cis
     *
     * @param integer $cis
     *
     * @return Medicine
     */
    public function setCis($cis)
    {
        $this->cis = $cis;

        return $this;
    }

    /**
     * Get cis
     *
     * @return integer
     */
    public function getCis()
    {
        return $this->cis;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Medicine
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set administration
     *
     * @param string $administration
     *
     * @return Medicine
     */
    public function setAdministration($administration)
    {
        $this->administration = $administration;

        return $this;
    }

    /**
     * Get administration
     *
     * @return string
     */
    public function getAdministration()
    {
        return $this->administration;
    }

    /**
     * Set autorisation
     *
     * @param string $autorisation
     *
     * @return Medicine
     */
    public function setAutorisation($autorisation)
    {
        $this->autorisation = $autorisation;

        return $this;
    }

    /**
     * Get autorisation
     *
     * @return string
     */
    public function getAutorisation()
    {
        return $this->autorisation;
    }

    /**
     * Set procedure
     *
     * @param string $procedure
     *
     * @return Medicine
     */
    public function setProcedure($procedure)
    {
        $this->procedure = $procedure;

        return $this;
    }

    /**
     * Get procedure
     *
     * @return string
     */
    public function getProcedure()
    {
        return $this->procedure;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Medicine
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set dateAutorisation
     *
     * @param \DateTime $dateAutorisation
     *
     * @return Medicine
     */
    public function setDateAutorisation($dateAutorisation)
    {
        $this->date_autorisation = $dateAutorisation;

        return $this;
    }

    /**
     * Get dateAutorisation
     *
     * @return \DateTime
     */
    public function getDateAutorisation()
    {
        return $this->date_autorisation;
    }

    /**
     * Set availability
     *
     * @param string $availability
     *
     * @return Medicine
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set autorisationNumber
     *
     * @param string $autorisationNumber
     *
     * @return Medicine
     */
    public function setAutorisationNumber($autorisationNumber)
    {
        $this->autorisation_number = $autorisationNumber;

        return $this;
    }

    /**
     * Get autorisationNumber
     *
     * @return string
     */
    public function getAutorisationNumber()
    {
        return $this->autorisation_number;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Medicine
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set security
     *
     * @param boolean $security
     *
     * @return Medicine
     */
    public function setSecurity($security)
    {
        $this->security = $security;

        return $this;
    }

    /**
     * Get security
     *
     * @return boolean
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Medicine
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Medicine
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->date_updated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->date_updated;
    }

    /**
     * Serialize Medidicine attributes for the render
     *
     * @return [type] [serialize Medidicine]
     */
    public function serialize(){
        return get_object_vars($this);
    }
}