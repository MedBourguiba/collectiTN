<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AvisFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = [];

        // create 10 users
        for ($i = 0; $i < 2000; $i++) {
            $user = new Utilisateur();
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'password'
            ));
            $manager->persist($user);
            $users[] = $user;
        }

        // create 20 random avis
        for ($i = 0; $i < 2000; $i++) {
            $avi = new Avis();
            $avi->setCommentaire(join(" ", $faker->words(5)));
            $avi->setDateAvis($faker->dateTimeThisMonth);
            $avi->setClient($faker->randomElement($users));
            $avi->setPartenaire($faker->randomElement($users));
            $manager->persist($avi);
        }

        $manager->flush();
    }
}

