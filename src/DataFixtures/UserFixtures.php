<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        // Crea usuario administrador de prueba
        $user = new Usuario();
        $user->setEmail('admin@example.com');
        $user->setRoles(['ROLE_ADMIN']);

        $hash = $this->encoder->encodePassword($user, 'password123');
        $user->setPassword($hash);

        $manager->persist($user);
        $manager->flush();
    }
}
