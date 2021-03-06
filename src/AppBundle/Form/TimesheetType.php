<?php

namespace AppBundle\Form;

use AppBundle\Entity\Timesheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Services\TimesheetManager;

/**
 * Defines the form used to create and manipulate transports.
 */
class TimesheetType extends AbstractType
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transport')
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
            ))
            ->add('client')
            ->add('departureFromTerminalTime', TimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('startingMileage')
            ->add('arrivalToClientTime', TimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('offloadingTime')
            ->add('departureFromClientTime', TimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('arrivalAtTerminalTime', TimeType::class, array(
                'widget' => 'single_text',
            ))
            ->add('finishingMileage')
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $form = $event->getForm();
            $timesheet = $event->getData();
            if (null !== $timesheet->getId()) {
                $form->add('distance', null, ['disabled' => true]);
                $form->add('cost', null, ['disabled' => true]);
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

            $timesheet = $event->getData();

            $timesheet->setUser($this->token->getToken()->getUser());
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

            $timesheet = $event->getData();
            $distance = $timesheet->getFinishingMileage() - $timesheet->getStartingMileage();

            $timesheet->setDistance($distance);
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

            $timesheet = $event->getData();
            $timesheetManager = new TimesheetManager($timesheet);
            $totalCost = $timesheetManager->getTotalCost();

            $timesheet->setCost($totalCost);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Timesheet::class,
        ]);
    }
}
