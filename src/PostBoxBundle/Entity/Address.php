<?php

namespace PostBoxBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="PostBoxBundle\Repository\AddressRepository")
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="blockNo", type="string", length=255)
     */
    private $blockNo;

    /**
     * @var string
     *
     * @ORM\Column(name="apartmentsNo", type="string", length=255)
     */
    private $apartmentsNo;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="addresses")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */    
    private $userId;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set blockNo
     *
     * @param string $blockNo
     * @return Address
     */
    public function setBlockNo($blockNo)
    {
        $this->blockNo = $blockNo;

        return $this;
    }

    /**
     * Get blockNo
     *
     * @return string 
     */
    public function getBlockNo()
    {
        return $this->blockNo;
    }

    /**
     * Set apartmentsNo
     *
     * @param string $apartmentsNo
     * @return Address
     */
    public function setApartmentsNo($apartmentsNo)
    {
        $this->apartmentsNo = $apartmentsNo;

        return $this;
    }

    /**
     * Get apartmentsNo
     *
     * @return string 
     */
    public function getApartmentsNo()
    {
        return $this->apartmentsNo;
    }

    /**
     * Set userId
     *
     * @param \PostBoxBundle\Entity\User $userId
     * @return Address
     */
    public function setUserId(\PostBoxBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \PostBoxBundle\Entity\User 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
