<?php

namespace App\DataFixtures;

use App\Entity\Pharmacie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($n=1; $n<=20; $n++){
            $pharma = new Pharmacie;
            $pharma->setNom('pharmacie n°'.$n);
            $pharma->setQuartier('quartier n°'.$n);
            $pharma->setVille('ville n°'.$n);
            $pharma->setGarde('dimanche,mercredi');

            $manager->persist($pharma);
        }

        $manager->flush();
    }
}
