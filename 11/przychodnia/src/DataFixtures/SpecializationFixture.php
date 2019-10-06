<?php


namespace App\DataFixtures;


use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\Specialization;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SpecializationFixture extends Fixture
{
    public const REF_UROLOG = 'urolog';
    public const REF_KARDIOLOG = 'kardiolog';
    public const REF_GINEKOLOG = 'ginekolog';

    public function load(ObjectManager $manager)
    {
        $specialization1 = new Specialization();
        $specialization1->setName('Urolog');
        $manager->persist($specialization1);
        $this->addReference(self::REF_UROLOG, $specialization1);

        $specialization2 = new Specialization();
        $specialization2->setName('Kardiolog');
        $manager->persist($specialization2);
        $this->addReference(self::REF_KARDIOLOG, $specialization2);

        $specialization3 = new Specialization();
        $specialization3->setName('Ginekolog');
        $manager->persist($specialization3);
        $this->addReference(self::REF_GINEKOLOG, $specialization3);

        $manager->flush();
    }
}