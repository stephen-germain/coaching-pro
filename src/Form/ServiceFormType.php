<?php

namespace App\Form;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ServiceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activity', TextType::class,[
                'required' => true,
                'label' => 'Nom de l\'activité',
                'attr' => [
                    'placeholder' => 'ex: Prise de masse',
                ]
            ])
            // ->add('activity', EntityType::class,[
            //     'class' => Services::class,
            //     'required' => true,
            //     'choice_label' => 'activity',
            //     // 'attr' => [
            //     //     'placeholder' => 'ex: Prise de masse',
            //     // ]
            // ])
            ->add('price', IntegerType::class, [
                'required' => true,
                'label' => 'Tarif',
                'attr' => [
                    'placeholder' => 'ex: 45',
                    'min' => 0
                ]
            ])
            ->add('time', IntegerType::class, [
                'required' => true,
                'label' => 'Durée',
                'attr' => [
                    'placeholder' => 'ex: 45',
                    'min' => 0
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
