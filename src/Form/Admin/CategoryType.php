<?php

namespace App\Form\Admin;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la categorie :',
                'attr' => [
                    'placeholder' => 'Nom de la catégorie',
                ]
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description de la catégorie',
                ]
            ])
            ->add('isInMenu', ChoiceType::class, [
                'label' => 'Navbar',
                'placeholder' => '-- Dans le menu de navbar --',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
