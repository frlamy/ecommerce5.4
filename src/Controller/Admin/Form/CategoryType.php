<?php

namespace App\Controller\Admin\Form;

use App\Entity\Category;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
                'label' => 'Name'
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Description'
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
            $form = $event->getForm();

            $category = $form->getData();

            if($category->getId() !== null) {
                $form
                    ->add('id', TextType::class, [
                        'label' => 'ID',
                        'disabled' => true,
                        'required' => false,
                    ])
                    ->add('slug', TextType::class, [
                        'label' => 'Slug',
                        'disabled' => true,
                        'required' => false,
                    ])
                    ->add('createdAt', DateTimeType::class, [
                        'label' => 'Created at',
                        'widget' => 'single_text',
                        'disabled' => true,
                        'required' => false,
                    ])
                ;
            }

        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
