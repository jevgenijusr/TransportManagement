<?php


namespace AppBundle\Form;

use AppBundle\Entity\Timesheet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to create and manipulate transports.
 */
class TimesheetType extends AbstractType
{
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
