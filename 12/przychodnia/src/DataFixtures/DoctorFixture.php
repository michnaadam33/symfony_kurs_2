<?php


namespace App\DataFixtures;


use App\Entity\Doctor;
use App\Entity\Patient;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DoctorFixture extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $doctor1 = new Doctor();
        $doctor1->setRoles(['ROLE_USER', 'ROLE_DOCTOR']);
        $doctor1->setEmail('doctor@doctor.com');
        $doctor1->setPassword($this->passwordEncoder->encodePassword($doctor1, 'pass'));
        $doctor1->setFirstName('Justyna');
        $doctor1->setLastName('Wrona');
        $doctor1->setSpecialization($this->getReference(SpecializationFixture::REF_GINEKOLOG));
        $manager->persist($doctor1);

        $doctor2 = new Doctor();
        $doctor2->setRoles(['ROLE_USER', 'ROLE_DOCTOR']);
        $doctor2->setEmail('doctor2@doctor.com');
        $doctor2->setPassword($this->passwordEncoder->encodePassword($doctor2, 'pass'));
        $doctor2->setFirstName('Michał');
        $doctor2->setLastName('Mazur');
        $doctor2->setSpecialization($this->getReference(SpecializationFixture::REF_KARDIOLOG));
        $manager->persist($doctor2);

        $doctor3 = new Doctor();
        $doctor3->setRoles(['ROLE_USER', 'ROLE_DOCTOR']);
        $doctor3->setEmail('doctor3@doctor.com');
        $doctor3->setPassword($this->passwordEncoder->encodePassword($doctor3, 'pass'));
        $doctor3->setFirstName('Jerzy');
        $doctor3->setLastName('Synowiec');
        $doctor3->setSpecialization($this->getReference(SpecializationFixture::REF_UROLOG));
        $manager->persist($doctor3);

        $doctor4 = new Doctor();
        $doctor4->setRoles(['ROLE_USER', 'ROLE_DOCTOR']);
        $doctor4->setEmail('doctor4@doctor.com');
        $doctor4->setPassword($this->passwordEncoder->encodePassword($doctor4, 'pass'));
        $doctor4->setFirstName('Ewelina');
        $doctor4->setLastName('Jankowska');
        $doctor4->setSpecialization($this->getReference(SpecializationFixture::REF_GINEKOLOG));
        $manager->persist($doctor4);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [SpecializationFixture::class];
    }

}