<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="symfony_demo_timesheet")
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
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $client;

    /**
     * @ORM\Column(type="time")
     */
    private $departureFromTerminalTime;

    /**
     * @ORM\Column(type="string")
     */
    private $startingMileage;

    /**
     * @ORM\Column(type="time")
     */
    private $arrivalToClientTime;

    /**
     * @ORM\Column(type="string")
     */
    private $offloadingTime;

    /**
     * @ORM\Column(type="time")
     */
    private $departureFromClientTime;

    /**
     * @ORM\Column(type="time")
     */
    private $arrivalAtTerminalTime;

    /**
     * @ORM\Column(type="string")
     */
    private $finishingMileage;

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
}