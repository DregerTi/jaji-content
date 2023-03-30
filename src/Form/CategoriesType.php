<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', null, [
                'label' => 'Nom de la catégorie',
                'attr' => [
                    'placeholder' => 'Nom de la catégorie',
                ],
            ])
            ->add('iconReference', null, [
                'label' => 'Icône de la catégorie',
                'attr' => [
                    'placeholder' => 'Icône de la catégorie',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
