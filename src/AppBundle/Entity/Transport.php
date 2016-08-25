<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="symfony_demo_transport")
 */
class Transport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $standing;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $driving;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $offloading;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getOffloading()
    {
        return $this->offloading;
    }

    /**
     * @param mixed $offloading
     */
    public function setOffloading($offloading)
    {
        $this->offloading = $offloading;
    }

    /**
     * @return mixed
     */
    public function getStanding()
    {
        return $this->standing;
    }

    /**
     * @param mixed $standing
     */
    public function setStanding($standing)
    {
        $this->standing = $standing;
    }

    /**
     * @return mixed
     */
    public function getDriving()
    {
        return $this->driving;
    }

    /**
     * @param mixed $driving
     */
    public function setDriving($driving)
    {
        $this->driving = $driving;
    }
}