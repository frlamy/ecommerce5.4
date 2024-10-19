<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Bezhanov\Faker\Provider\Commerce;
use Bluemmb\Faker\PicsumPhotosProvider;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Liior\Faker\Prices;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $slugger;
    protected $hasher;

    public function __construct(Slugify $slugger, UserPasswordHasherInterface $hasher) {
        $this->slugger = $slugger;
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer une instance de Faker en spécifiant la locale française
        $faker = Factory::create('fr_FR');

        $faker->addProvider(new Prices($faker));
        $faker->addProvider(new Commerce($faker));
        $faker->addProvider(new PicsumPhotosProvider($faker));

        // Creation admin user : TODO table adminusers et frontusers
        $admin = new User();

        $admin
            ->setEmail("admin@gmail.com")
            ->setPassword($this->hasher->hashPassword($admin, 'password'))
            ->setFullName('Admin')
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        // Création users front
        for($u = 0; $u < 5; $u++) {
            $user = new User();

            $user
                ->setEmail("user$u@gmail.com")
                ->setPassword($this->hasher->hashPassword($user, 'password'))
                ->setFullName($faker->name());

            $manager->persist($user);
        }

        for($c = 0; $c < 5; $c++) {
            $category = new Category();

            $category
                ->setName($faker->category())
                ->setSlug($this->slugger->slugify($category->getName()))
                ->setShortDescription($faker->paragraph(1))
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setIsInMenu(false)
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
                    ->setPublishedAt(null)
                    ->setStatus(Product::STATUS_DRAFT)
                    ->addCategory($category)
                ;

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
