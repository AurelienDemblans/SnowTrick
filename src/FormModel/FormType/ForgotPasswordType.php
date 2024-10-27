<?php

namespace App\FormModel\FormType;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForgotPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Entrez votre e-mail',
                'attr' => [
                    'placeholder' => 'exemple@email.fr',
                    'class' => 'form-control'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Demander la réinialisation du mot de passe'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
