<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickGroup;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Url;

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
                'mapped' => false,
                'multiple' => true,
                'required' => false,
            ])
            ->add('trickPictures', FileType::class, [
                'label' => 'Ajouter des images ',
                'multiple' => true,
                'mapped' => false,
                'required' => $options['picture_required'],
            ])
            ->add('trickVideosUrl', CollectionType::class, [
                'required' => false,
                'mapped' => false,
                'entry_type' => TextType::class,
                'entry_options' => [
                    'label' => 'lien vers une vidéo',
                    'constraints' => [
                        new Url([
                            'message' => 'Veuillez entrer une URL valide.',
                        ]),
                    ],
                ],
                'label' => false,
                'data' => array_fill(0, 3, ''),
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'picture_required' => true,
        ]);
    }
}
