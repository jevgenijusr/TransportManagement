<?php

namespace AppBundle\Form;

use AppBundle\Entity\Timesheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
    private $timesheetManager;
    
    public function __construct(TimesheetManager $timesheetManager)
    {
        $this->timesheetManager = $timesheetManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.title',
            ])
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
            if ($timesheet || null !== $timesheet->getId()) {
                $form->add('distance');
                $form->add('cost');
            }
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

            $timesheet = $event->getData();
            
            $distance = $timesheet->getFinishingMileage() - $timesheet->getStartingMileage();

            $timesheet->setDistance($distance);
            
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

            $timesheet = $event->getData();

            $totalCost = $this->timesheetManager->getTotalCost($timesheet);
                
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
