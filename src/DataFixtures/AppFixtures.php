<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('adams@gmail.com');
        $user->setNom('adams');
        $user->setRoles(["ROLE_PARENT"]);
        $user->setIsActive(1);
        $user->setPassword('$2y$13$JTarRZarpqGSSpcpDMakv.oJYAR4J8PKFjJK6RZy/Mj42XKReazJO');

        $user1 = new User();
        $user1->setEmail('adam@gmail.com');
        $user1->setNom('adam');
        $user1->setIsActive(1);
        $user1->setRoles(["ROLE_ECOLE"]);
        $user1->setPassword('$2y$13$JTarRZarpqGSSpcpDMakv.oJYAR4J8PKFjJK6RZy/Mj42XKReazJO');

        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}
