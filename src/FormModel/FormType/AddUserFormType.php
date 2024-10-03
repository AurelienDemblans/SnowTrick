<?php

namespace App\FormModel\FormType;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class AddUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => $options['require_due_date'],
                'constraints' => [
                new Assert\Length([
                    'min' => 2,
                    'max' => 10,
                    'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                    'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
            ])
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, ['label' => 'Mot de passe','constraints' => [
                new Assert\Length([
                    'min' => 6,
                    'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.',
                ]),
            ]])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'require_due_date' => false,
        ]);

        $resolver->setAllowedTypes('require_due_date', 'bool');
    }
}
