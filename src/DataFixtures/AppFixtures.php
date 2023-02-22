<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Liior\Faker\Prices;

class AppFixtures extends Fixture
{
    protected $slugger;

    public function __construct(Slugify $slugger) {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $faker->addProvider(new Prices($faker));
        $faker->addProvider(new Commerce($faker));
        $faker->addProvider(new PicsumPhotosProvider($faker));

        for($c = 0; $c < 5; $c++) {
            $category = new Category();

            $category
                ->setName($faker->category())
                ->setSlug($this->slugger->slugify($category->getName()))
                ->setShortDescription($faker->paragraph(1))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
            ;

            $manager->persist($category);

            for($p = 0; $p < random_int(5, 10); $p++) {
                $product = new Product();

                $product
                    ->setName($faker->productName())
                    ->setSlug($this->slugger->slugify($product->getName()))
                    ->setPrice($faker->price(4000, 20000))
                    ->setShortDescription($faker->paragraph(1))
                    ->setMainPicture($faker->imageUrl(400, 400, true))
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setUpdatedAt(new \DateTimeImmutable())
                    ->addCategory($category)
                ;

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
