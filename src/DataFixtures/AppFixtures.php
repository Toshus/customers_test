<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer
            ->setGender('male')
            ->setNameTitle('Mr')
            ->setFirstName('John')
            ->setLastName('Doe')
            ->setStreet('Baker')
            ->setCity('London')
            ->setState('TestState')
            ->setCountry('England')
            ->setPostcode(111)
            ->setLatitude('12')
            ->setLongitude('34')
            ->setTimezoneDescription('test')
            ->setTimezoneOffset('0')
            ->setEmail('test@test.com')
            ->setUuid('test')
            ->setUsername('test')
            ->setPassword('test')
            ->setSalt('testSalt')
            ->setHashmd5('aaaa')
            ->setHashsha1('bbbb')
            ->setHashsha256('cccc')
            ->setBirthday(new DateTime('2020-01-01T10:00:00.100Z'))
            ->setRegistered(new DateTime('2020-01-01T10:00:00.100Z'))
            ->setPhone('111-11-11')
            ->setCell('222-22-22')
            ->setIdName('test')
            ->setIdValue('testValue')
            ->setPictureLg('')
            ->setPictureMed('')
            ->setPictureThumb('')
            ->setNationality('AU');
        
        $manager->persist($customer);

        $manager->flush();
    }
}
