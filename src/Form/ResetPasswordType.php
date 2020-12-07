<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrength;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Les deux mots de passe doivent être identique',
            'options' => ['attr' => ['class' => 'password-field']],
            'required' => true,
            'first_options'  => ['label' => 'Mot de passe'],
            'second_options' => ['label' => 'Confirmer le mot de passe'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez rentrer un nouveau mot de passs',
                ]),
                // new Length([
                //     'min' => 6,
                //     'minMessage' => 'Your password should be at least {{ limit }} characters',
                //     // max length allowed by Symfony for security reasons
                //     'max' => 4096,
                // ]),
                new PasswordStrength([
                    // longueur mini
                    'minLength' => 8,
                    'tooShortMessage' => 'Le mot de passe doit contenir au moins 8 caractères',
                    // force mini
                    'minStrength' => 4,
                    'message' => 'Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule, un chiffre et un caractère spécial'
                ])
            ]
        ])
        ->add('save', SubmitType::class,[
            'label' => 'Enregistrer'
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
