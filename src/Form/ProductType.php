<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use App\Type\CustomMoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Nom du produit',
                ]
            ])
            ->add('price', CustomMoneyType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'O.OO€',
                ]
            ])
            ->add('mainPicture',
                TextType::class, [
                'label' => 'Media',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://picsum.photos/400/400',
                ]
            ])
            ->add('shortDescription',
                TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('status',
                ChoiceType::class, [
                'choices' => [
                    'draft' => Product::STATUS_DRAFT,
                    'published' => Product::STATUS_PUBLISHED
                ]
            ])
            ->add(
                'categories',
                EntityType::class, [
                    'label' => 'Categories',
                    'placeholder' => '--Select a category--',
                    'class' => Category::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'required' => false,
                ]
            )

//            ->get('price')->addModelTransformer(new PriceTransformer()); // wen can also use a CallbackTransformer instead of using a customtype
//
//            ->addEventListener(
//                FormEvents::PRE_SET_DATA,
//                [$this, 'onPreSetData']
//            )
//            ->addEventListener(
//                FormEvents::POST_SUBMIT,
//                [$this, 'onPostSubmit']
//            )
        ;

        // Idem qu'au dessus
//        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
//            /** @var Product $product */
//            $product = $event->getData();
//
//            $product->setPrice($product->getPrice() / 100);
//        });
    }

//    public function onPreSetData(FormEvent $event): void
//    {
//        /** @var Product $product */
//        $product = $event->getData();
//
//        if ($product !== null) {
//           //TODO
//        }
//    }
//
//    public function onPostSetData(FormEvent $event): void
//    {
//        $form = $event->getForm();
//        dd($form, $event);
//        // TODO
//    }
//
//    public function onPreSubmit(FormEvent $event): void
//    {
//        $form = $event->getForm();
//        dd($form, $event);
//        // TODO
//    }
//
//    public function onPostSubmit(FormEvent $event): void
//    {
//        /** @var Product $product */
//        $product = $event->getData();
//
//        if ($product !== null) {
//            //TODO
//        }
//    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
