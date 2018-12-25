<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
 

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
    	$this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        //On configure dans quelle langue nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        //On crée 10 users
        for ($i=0; $i < 10; $i++) { 
        	$user = new User();
        	$user->setNomComplet($faker->name);
        	$user->setEmail(sprintf('userdemo%d@example.com', $i));
        	$user->setPassword($this->passwordEncoder->encodePassword(
        		$user,
        		'userDemo'
        	));

        	$manager->persist($user);
    	}

    $manager->flush();

	}
}
