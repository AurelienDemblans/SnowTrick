<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('trickGroup', EntityType::class, [
                'label' => 'Groupe du Trick',
                'class' => TrickGroup::class,
                'choice_label' => 'name',
            ])
            ->add('trickVideos', FileType::class, [
                'label' => 'Ajouter des vidéos ',
                'multiple' => true,
                'mapped' => false,
                'required' => false,
            ])
            ->add('trickPictures', FileType::class, [
                'label' => 'Ajouter des images ',
                'multiple' => true,
                'mapped' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
