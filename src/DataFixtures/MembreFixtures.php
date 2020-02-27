<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Membre;


class MembreFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->createMany(150, "membre" , function($num){
            $membre = new Membre;
            $membre->setNom($this->faker->lastName);
            $membre->setPrenom($this->faker->firstName);
            $email = "membre" . $num . "@equidannonce.com";
            $membre->setEmail($email);
            $membre->setRoles(["ROLE_USER"]);
            $membre->setPassword(password_hash("membre" . $num, PASSWORD_DEFAULT));
            $membre->setPseudo("membre$num");
            $membre->setTelephone($this->faker->e164PhoneNumber);
            $membre->setCivilite($this->faker->randomElement(["H", "F", "A"]));
            $membre->setDateEnregistrement($this->faker->dateTime());
            return $membre;
        });

        $this->createMany(5, "admin" , function($num){
            $email = "admin" . $num . "@equidannonce.com";
            $membreAdmin = (new Membre)
                ->setEmail($email)
                ->setRoles(["ROLE_ADMIN"])
                ->setPassword( password_hash("admin" . $num, PASSWORD_DEFAULT))
                ->setNom( $this->faker->lastName)
                ->setPrenom( $this->faker->firstName)
                ->setCivilite($this->faker->randomElement(["H", "F", "A"]))
                ->setPseudo("admin$num")
                ->setTelephone($this->faker->e164PhoneNumber)
                ->setDateEnregistrement($this->faker->dateTime());
            return $membreAdmin;
        });

        $manager->flush();
    }
}
