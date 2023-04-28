<?php

namespace App\DataFixtures;

use App\Entity\Server;
use App\Entity\Database;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un user "normal"
        $user = new User();
        $user->setUsername("user");
        $user->setEmail("user@bookapi.com");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);

        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setUsername("admin");
        $userAdmin->setEmail("admin@bookapi.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $userAdmin->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($userAdmin);

//        // Création des serveurs avec databases.
//        $listServer = [];
//        for ($i = 0; $i < 10; $i++) {
//            // Création de l'auteur lui-même.
//            $server = new Server();
//            $server->setName("Serveur " . $i);
//            $manager->persist($server);
//
//            // On sauvegarde l'auteur créé dans un tableau.
//            $listServer[] = $server;
//        }
//
//        for ($i = 0; $i < 20; $i++) {
//            $book = new Book();
//            $book->setTitle("Titre " . $i);
//            $book->setCoverText("Quatrième de couverture numéro : " . $i);
//            $book->setAuthor($listAuthor[array_rand($listAuthor)]);
//            $manager->persist($book);
//        }

        $manager->flush();
    }
}
