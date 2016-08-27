<?php

namespace AppBundle\Services;

use AppBundle\Entity\Timesheet;

class TimesheetManager
{
    private $timesheet;

    private $transport;
    
    public function getTotalCost(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
        $this->transport = $this->timesheet->getTransport();
        
        $totalCost = $this->getDrivingCost() + $this->getStandingCost() + $this->getOffloadingCost(); 
        
        return $totalCost;
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

    private function getStandingTime()
    {
        $totalTimeSpentAtTheClient = $this->getTimeIntervalInMinutes(
            $this->timesheet->getArrivalToClientTime(),
            $this->timesheet->getDepartureFromClientTime()
        );

        return $totalTimeSpentAtTheClient - $this->timesheet->getOffloadingTime();
    }

    private function getTimeIntervalInMinutes(\DateTime $startTime, \DateTime $endTime)
    {
        return ($endTime->getTimestamp() - $startTime->getTimestamp()) / 60;
    }
}