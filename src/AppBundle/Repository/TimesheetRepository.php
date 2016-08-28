<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TimesheetRepository extends EntityRepository
{
    public function findForYearAndMonth($month, $userId)
    {
        $dateStart = new \DateTime($month);
        $dateEnd = clone $dateStart;
        $dateEnd = $dateEnd->modify('last day of this month');

        $query = $this->getEntityManager()
            ->createQuery('
                SELECT t
                FROM AppBundle:timesheet t
                WHERE (t.date BETWEEN :first_day AND :last_day) AND (t.user = :user_id)
            ')
            ->setParameters([
                'first_day' => $dateStart->format('Y-m-d'),
                'last_day' => $dateEnd->format('Y-m-d'),
                'user_id' => $userId
            ]);
        ;

        return $query->getResult();
    }
}
