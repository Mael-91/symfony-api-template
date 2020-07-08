<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create dummy data
        $faker = Factory::create();

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
