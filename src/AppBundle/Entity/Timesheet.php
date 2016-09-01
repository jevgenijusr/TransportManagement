<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TimesheetRepository")
 * @ORM\Table(name="symfony_demo_timesheet")
 * @Assert\Callback({"AppBundle\Validators\TimesheetValidator", "validate"})
 */
class Timesheet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Transport")
     */
    private $transport;

    /**
     * @ORM\Column(type="date")
     * @Assert\DateTime()
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $client;

    /**
     * @ORM\Column(type="time")
     * @Assert\Time()
     */
    private $departureFromTerminalTime;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\NotBlank()
     * @Assert\Range(min=1)
     */
    private $startingMileage;

    /**
     * @ORM\Column(type="time")
     */
    private $arrivalToClientTime;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\NotBlank()
     * @Assert\Range(min=1)
     */
    private $offloadingTime;

    /**
     * @ORM\Column(type="time")
     * @Assert\Time()
     */
    private $departureFromClientTime;

    /**
     * @ORM\Column(type="time")
     * @Assert\Time()
     */
    private $arrivalAtTerminalTime;

    /**
     * @ORM\Column(type="string")
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\NotBlank()
     * @Assert\Range(min=1)
     */
    private $finishingMileage;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $distance;

    /**
     * @ORM\Column(type="string", nullable=true)
     */    
    private $cost;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     */
    private $user;

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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getDepartureFromTerminalTime()
    {
        return $this->departureFromTerminalTime;
    }

    /**
     * @param mixed $departureFromTerminalTime
     */
    public function setDepartureFromTerminalTime($departureFromTerminalTime)
    {
        $this->departureFromTerminalTime = $departureFromTerminalTime;
    }

    /**
     * @return mixed
     */
    public function getStartingMileage()
    {
        return $this->startingMileage;
    }

    /**
     * @param mixed $startingMileage
     */
    public function setStartingMileage($startingMileage)
    {
        $this->startingMileage = $startingMileage;
    }

    /**
     * @return mixed
     */
    public function getArrivalToClientTime()
    {
        return $this->arrivalToClientTime;
    }

    /**
     * @param mixed $arrivalToClientTime
     */
    public function setArrivalToClientTime($arrivalToClientTime)
    {
        $this->arrivalToClientTime = $arrivalToClientTime;
    }

    /**
     * @return mixed
     */
    public function getOffloadingTime()
    {
        return $this->offloadingTime;
    }

    /**
     * @param mixed $offloadingTime
     */
    public function setOffloadingTime($offloadingTime)
    {
        $this->offloadingTime = $offloadingTime;
    }

    /**
     * @return mixed
     */
    public function getArrivalAtTerminalTime()
    {
        return $this->arrivalAtTerminalTime;
    }

    /**
     * @param mixed $arrivalAtTerminalTime
     */
    public function setArrivalAtTerminalTime($arrivalAtTerminalTime)
    {
        $this->arrivalAtTerminalTime = $arrivalAtTerminalTime;
    }

    /**
     * @return mixed
     */
    public function getFinishingMileage()
    {
        return $this->finishingMileage;
    }

    /**
     * @param mixed $finishingMileage
     */
    public function setFinishingMileage($finishingMileage)
    {
        $this->finishingMileage = $finishingMileage;
    }

    /**
     * @return mixed
     */
    public function getDepartureFromClientTime()
    {
        return $this->departureFromClientTime;
    }

    /**
     * @param mixed $departureFromClientTime
     */
    public function setDepartureFromClientTime($departureFromClientTime)
    {
        $this->departureFromClientTime = $departureFromClientTime;
    }

    /**
     * @return mixed
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param mixed $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}