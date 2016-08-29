<?php

namespace AppBundle\Form;

use AppBundle\Entity\Transport;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to create and manipulate transports.
 */
class ChooseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.username <> \'anna_admin\'')
                        ->orderBy('u.username', 'ASC');
                },
                'choice_label' => 'username',
            ))
            ->add('date', null, array(
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('save', SubmitType::class, array('label' => 'Filter'))
        ;


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
