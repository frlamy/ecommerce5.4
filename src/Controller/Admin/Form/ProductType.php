<?php

namespace App\Controller\Admin\Form;

use App\Entity\Category;
use App\Entity\Product;
use Faker\Provider\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name'
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price'
            ])
//            ->add('slug')
//            ->add('createdAt')
//            ->add('updatedAt')
            ->add('mainPicture', UrlType::class, [
                'label' => 'Picture',
            ])
            ->add('shortDescription', TextareaType::class, [
                'label' => 'Product description'
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Categories',
                'placeholder' => '-- Choose a category --',
                'class' => Category::class,
                'choice_label' => function (Category $category) {
                    return strtoupper($category->getName());
                },
                'choice_attr' => function (?Category $category) {
                    return $category ? ['class' => 'category_'.strtolower($category->getName())] : [];
                },
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
