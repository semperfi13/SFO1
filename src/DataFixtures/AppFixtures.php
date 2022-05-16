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
        $user->setRoles(["ROLE_PARENT"]);
        $user->setPassword('$2y$13$6Q8tj6dCj9E8qlzYjv3ks.r7zjFpCjr3CyT2pg4ggGuLLy03WsCL2');

        $user1 = new User();
        $user1->setEmail('adam@gmail.com');
        $user1->setRoles(["ROLE_ECOLE"]);
        $user1->setPassword('$2y$13$gD6lpyQ5xUZNIcMl6e5j8OJrH0DdnLMJXZH6xLgMq2Fh59DGKFz22');

        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}
