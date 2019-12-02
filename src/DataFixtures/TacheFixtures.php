<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tache;

class TacheFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 5; $i++){
            $tache = new Tache();
            $tache->setTitle("Titre de la tache n°$i")
                  ->setContent("<p>Contenu de la tache n°$i")
                  ->setCreatedAt(new \DateTime());

            $manager->persist($tache);
        }

        $manager->flush();
    }
}
