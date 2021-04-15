<?php

declare(strict_types=1);

namespace App\Tests\unit\Controller;

use App\Controller\CustomersController;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Tests\unit\UnitCommon;
use DateTime;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CustomersControllerTest extends UnitCommon
{
    
    public function testGetCustomerList()
    {
        $expects = '{"total":1,"result":[{"id":1,"country":"England","email":"test@test.com","fullName":"John Doe"}]}';
        $request = $this->createMockObject(Request::class);
        $request->expects($this->exactly(2))->method('get')->willReturnCallback(function ($key) {
            if ('limit' === $key) {
                return 10;
            }
            if ('offset' === $key) {
                return 0;
            }
            
            return null;
        });
        
        $repository = $this->createMockObject(CustomerRepository::class);
        $customer = $this->getCustomer();
        $repository->expects($this->once())->method('getList')->willReturn([$customer]);
        $repository->expects($this->once())->method('getTotalCount')->willReturn(1);
        
        $serializer = $this->createSerializer();
        $controller = $this->createController(['serializer' => $serializer]);
        
        $response = $controller->getCustomersList($request, $repository);
        
        $this->assertJsonStringEqualsJsonString($expects, $response->getContent());
        $this->assertSame($response->getStatusCode(), Response::HTTP_OK);
    }
    
    public function testGetCustomerListWrongParamLimit()
    {
        $request = $this->createMockObject(Request::class);
        $request->expects($this->atLeast(1))->method('get')->willReturnCallback(function ($key) {
            if ('limit' === $key) {
                return 'aaa';
            }
            if ('offset' === $key) {
                return 0;
            }
            
            return null;
        });
        
        $repository = $this->createMockObject(CustomerRepository::class);
        $controller = $this->createController([]);
        
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Limit must be an integer positive value');
        $controller->getCustomersList($request, $repository);
    }
    
    public function testGetCustomerListWrongOffsetLimit()
    {
        $request = $this->createMockObject(Request::class);
        $request->expects($this->atLeast(1))->method('get')->willReturnCallback(function ($key) {
            if ('limit' === $key) {
                return 10;
            }
            if ('offset' === $key) {
                return 'bbb';
            }
            
            return null;
        });
        
        $repository = $this->createMockObject(CustomerRepository::class);
        $controller = $this->createController([]);
        
        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Offset must be an integer positive value');
        $controller->getCustomersList($request, $repository);
    }
    
    public function testGetCustomer()
    {
        $expects = '{"result":{"id":1,"gender":"male","country":"England","city":"London","email":"test@test.com","phone":"111-11-11", "username":"test","fullName":"John Doe"}}';
    
        $serializer = $this->createSerializer();
        $controller = $this->createController(['serializer' => $serializer]);

        $customer = $this->getCustomer();
        $response = $controller->getCustomer($customer);

        $this->assertJsonStringEqualsJsonString($expects, $response->getContent());
        $this->assertSame($response->getStatusCode(), Response::HTTP_OK);
    }
    
    private function createSerializer()
    {
        $encoders = [new JsonEncoder()];
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];
        
        return new Serializer($normalizers, $encoders);
    }
    
    private function createController(array $components): CustomersController
    {
        $controller = new CustomersController();
        $controller->setContainer($this->createMockContainer($components));
        
        return $controller;
    }
    
    private function createMockContainer(array $components): ContainerInterface
    {
        $container = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $container
            ->method('get')
            ->willReturnCallback(function ($key) use ($components) {
                return $components[$key] ?? null;
            });
        $container
            ->method('has')
            ->willReturnCallback(function ($key) use ($components) {
                return array_key_exists($key, $components);
            });
        
        return $container;
    }
    
    private function getCustomer()
    {
        $customer = new Customer();
        $customer
            ->setId(1)
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
        
        return $customer;
    }
}
