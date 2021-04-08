<?php
// src/DataFixtures/UserFixtures.php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
// utiliser la classe pour crypter le mot de passe
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    // injecter la classe de cryptage dans le service
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * Ajouter 2 admins :
     * yann.garet@etu.univ-poitiers.fr / issou en ROLE_ADMIN
     * chancle@issou.risific / thepedo78 en ROLE_WRITER
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        // un boss@gmail.com / boss en ROLE_ADMIN
        $user = new User();
        $user->setEmail('yann.garet@etu.univ-poitiers.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'issou'));
        $manager->persist($user);
        // un writer@gmail.com / writer en ROLE_WRITER
        $user = new User();
        $user->setEmail('chancle@issou.risific')
            ->setRoles(['ROLE_WRITER'])
            ->setPassword($this->passwordEncoder->encodePassword($user, 'thepedo78'));
        $manager->persist($user);
        $manager->flush();
    }
}