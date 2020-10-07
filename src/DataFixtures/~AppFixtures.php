<?php

namespace App\DataFixtures;

use App\Entity\Services;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $service = new Services();
        $service->setActivity('TRX');
        $service->setPrice('40');
        $service->setTime('45');
        $manager->persist($service);

        $manager->flush();
    }
}
