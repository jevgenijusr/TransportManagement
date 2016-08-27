<?php

namespace AppBundle\Services;

use AppBundle\Entity\Timesheet;

class TimesheetManager
{
    private $timesheet;

    private $transport;
    
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
        $this->transport = $this->timesheet->getTransport();
    }
    
    public function getTotalCost()
    {
        $totalCost = $this->getDrivingCost() + $this->getStandingCost() + $this->getOffloadingCost(); 
        
        return $totalCost;
    }
    
    public function getTimeSpentAtClient() 
    {
        return $totalTimeSpentAtTheClient = $this->getTimeIntervalInMinutes(
            $this->timesheet->getArrivalToClientTime(),
            $this->timesheet->getDepartureFromClientTime()
        );
    }

    private function getStandingTime()
    {
        return $this->getTimeSpentAtClient() - $this->timesheet->getOffloadingTime();
    }

    private function getDrivingCost()
    {
        $costPerMinute = $this->transport->getDriving() / 60;

        $drivingTime = $this->getTimeIntervalInMinutes(
            $this->timesheet->getDepartureFromTerminalTime(),
            $this->timesheet->getArrivalToClientTime()
        );

        $drivingTime += $this->getTimeIntervalInMinutes(
            $this->timesheet->getDepartureFromClientTime(),
            $this->timesheet->getArrivalAtTerminalTime()
        );

        return $drivingTime * $costPerMinute;
    }

    private function getOffloadingCost()
    {
        $costPerMinute = $this->transport->getOffloading() / 60;

        return $this->timesheet->getOffloadingTime() * $costPerMinute;
    }
    
    private function getStandingCost()
    {
        $costPerMinute = $this->transport->getStanding() / 60;

        return $this->getStandingTime() * $costPerMinute;
    }

    private function getTimeIntervalInMinutes(\DateTime $startTime, \DateTime $endTime)
    {
        return ($endTime->getTimestamp() - $startTime->getTimestamp()) / 60;
    }
}