<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('beginAt', DateTimeType::class, [
            'label' => 'Date de début',
            'widget' => 'single_text',
            'html5' => false,
            'attr' => ['class' => 'js-datepicker'],
            'format' => 'MM/dd/yyyy',
            ])
            // ->add('endAt')
            ->add('timeAt', DateTimeType::class, [
                'label' => 'heure',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => ['class' => 'timepicker'],
                'format' => 'hh:mm'
            ])

            // ->add('title', EntityType::class, [
            //     "class" => Services::class,
            //     'choice_label' => 'activity',
            //     'multiple' => true
            // ])
            ->add ('title', ChoiceType::class, [
                'choices' => [
                    'cardio-training' => 'cardio-training',
                    'tonification musculaire' => 'tonification musculaire',
                    'cross-training' => 'cross-training',
                    'prise de masse' => 'prise de masse',
                    'préparation physique' => 'préparation physique',
                    'TRX' => 'TRX',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
