<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hours = [];
        for ($i = 10; $i <= 18; $i++) {
            array_push($hours, strval($i));
        }
        $builder
        ->add('beginAt', DateTimeType::class, [
            'label' => 'Date de début',
            'date_widget' => 'single_text',
            'hours' => $hours,
            'minutes' => ["00", "30"],
            ])
            // ->add('endAt')
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
