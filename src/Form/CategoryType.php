<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom de la catégorie',
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'Slug',
                'required' => false,
                'disabled' => true,
            ])
           // ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit']);
        ;
    }

    public function onPreSubmit(FormEvent $event): void
    {
        // TODO
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
