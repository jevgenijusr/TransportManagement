<?php

namespace AppBundle\Validators;

use AppBundle\Entity\Timesheet;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use AppBundle\Services\TimesheetManager;

class TimesheetValidator
{
    public static function validate(Timesheet $timesheet, ExecutionContextInterface $context, $payload)
    {
        if($timesheet->getStartingMileage() >= $timesheet->getFinishingMileage())
        {
            $context->buildViolation('Starting mileage is less or equal to finish mileage')
                ->addViolation();
        }

        if($timesheet->getDepartureFromTerminalTime() >= $timesheet->getArrivalToClientTime())
        {
            $context->buildViolation('Departure from terminal time should be earlier than arriving at client time')
                ->addViolation();
        }

        if($timesheet->getDepartureFromClientTime() >= $timesheet->getArrivalAtTerminalTime())
        {
            $context->buildViolation('Departure from client time should be earlier than arriving at terminal time')
                ->addViolation();
        }

        if($timesheet->getDepartureFromClientTime() >= $timesheet->getArrivalAtTerminalTime())
        {
            $context->buildViolation('Departure from client time should be earlier than arriving at terminal time')
                ->addViolation();
        }

        $arrivalToClientTime = $timesheet->getArrivalToClientTime();
        $departureFromClientTime = $timesheet->getDepartureFromClientTime();

        if($arrivalToClientTime >= $departureFromClientTime)
        {
            $context->buildViolation('Arrival to client time (%arrival_time%) should be earlier than departure from client time (%departure_time%)')
                ->setParameters([
                    '%arrival_time%' => $arrivalToClientTime->format("H:i"),
                    '%departure_time%' => $departureFromClientTime->format("H:i"),
                ])
                ->addViolation();
        }

        $timesheetManager = new TimesheetManager($timesheet);

        $offloadingTime = $timesheet->getOffloadingTime();
        $timeSpentAtClient = $timesheetManager->getTimeSpentAtClient();

        if($offloadingTime >= $timeSpentAtClient)
        {
            $context->buildViolation('Offloading time (%offloading_time%) cannot exceed standing time (%standing_time%)')
                ->setParameters([
                    '%offloading_time%' => $offloadingTime,
                    '%standing_time%' => $timeSpentAtClient,
                ])
                ->addViolation();
        }
    }
}