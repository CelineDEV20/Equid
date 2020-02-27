<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Annonce;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnonceFixtures extends BaseFixtures implements DependentFixtureInterface
{

    public function loadData(ObjectManager $manager)
    {


        $this->createMany(8, "annonce", function($num){

            $ann = (new Annonce)
                ->setTitre($this->faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setDescriptionCourte($this->faker->paragraph($nbSentences = 3, $variableNbSentences = true))
                ->setDescriptionLongue($this->faker->paragraph($nbSentences = 5, $variableNbSentences = true))
                ->setPrix($this->faker->randomNumber(5))
                ->setAdresse($this->faker->streetAddress)
                ->setVille("Paris")
                ->setCp($this->faker->randomNumber($nbDigits = 5, $strict = true))
                ->setPays($this->faker->city)
                ->setMembre($this->getRandomReference("membre"))
                ->setCategorie($this->getRandomReference("cat"))
                ->setPhoto($this->getRandomReference("photo"))
                ->setDateEnregistrement($this->faker->dateTime());
            return $ann;
        });

        $manager->flush();
    }

    public function getDependencies(){
        return [ MembreFixtures::class, CategorieFixtures::class, PhotoFixtures::class ];
    }
}
