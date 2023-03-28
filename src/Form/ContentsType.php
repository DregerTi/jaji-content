<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Contents;
use App\Entity\Offers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ContentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'image',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de télécharger une photo valide.',
                    ])
                ],
            ])
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Article' => 'Article',
                    'YouTube' => 'YouTube',
                    'Spotify' => 'Spotify',
                    'Deezer' => 'Deezer',
                ]
            ])
            ->add('src', null, [
                'label' => 'Source',
                'required' => false,
            ])
            ->add('content', null, [
                'label' => 'Contenu',
            ])
            ->add('offers', EntityType::class, [
                'class' => Offers::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Offres',
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'label',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Catégories',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contents::class,
        ]);
    }
}
