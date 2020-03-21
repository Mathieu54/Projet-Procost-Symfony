<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture {

    function load(ObjectManager $manager) {

        $manager->persist($manager);
        $manager->flush();
    }

}

?>


