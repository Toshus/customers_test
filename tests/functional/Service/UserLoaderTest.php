<?php

declare(strict_types=1);

namespace App\Tests\functional\Service;

use App\Denormalizer\UsersDenormalizer;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use App\Service\CustomerService;
use App\Service\UserLoader;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UserLoaderTest extends KernelTestCase
{
    private EntityManager $em;
    
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->em = $kernel->getContainer()->get('doctrine')->getManager();
    }
    
    public function testLoadUsers()
    {
        $testContent = '{"results":[{"gender":"female","name":{"title":"Mrs","first":"Enya","last":"Skaare"},"location":{"street":{"number":4996,"name":"Kampheimveien"},"city":"Sogndalsfjøra","state":"Nord-Trøndelag","country":"Norway","postcode":"1928","coordinates":{"latitude":"57.7932","longitude":"114.6922"},"timezone":{"offset":"-3:00","description":"Brazil, Buenos Aires, Georgetown"}},"email":"enya.skaare@example.com","login":{"uuid":"4c8576b6-fcda-49f3-97f8-3d8f4ae271c8","username":"orangeduck835","password":"washington","salt":"UYOK9mZC","md5":"a0876243ed09f19561f44122454e5d68","sha1":"e707779105ba0b603dda6d83f904334abe0e6f26","sha256":"cecb9ccc84ee36b4d38ef721a2613ba94a21149bfaaceaf8aab6d8ddff0dab3f"},"dob":{"date":"1973-02-07T02:29:30.470Z","age":48},"registered":{"date":"2019-06-25T22:48:35.146Z","age":2},"phone":"68140858","cell":"46654534","id":{"name":"FN","value":"07027338016"},"picture":{"large":"https://randomuser.me/api/portraits/women/25.jpg","medium":"https://randomuser.me/api/portraits/med/women/25.jpg","thumbnail":"https://randomuser.me/api/portraits/thumb/women/25.jpg"},"nat":"NO"}],"info":{"seed":"b94439258a959aa8","results":1,"page":1,"version":"1.3"}}';
        $kernel = self::bootKernel();
        $httpClient = $this->getHttpClientMock($testContent);
        $denormalizer = new UsersDenormalizer();
        $customerService = $kernel->getContainer()->get(CustomerService::class);
        $userLoader = new UserLoader($httpClient, $denormalizer, $customerService, '');
        
        $userLoader->loadUsers([]);

        /** @var CustomerRepository $customerRepository */
        $customerRepository = $this->em->getRepository(Customer::class);
        
        /** @var Customer $customer */
        $customer = $customerRepository->findOneBy(['email' => 'enya.skaare@example.com']);
        
        $this->assertSame('Enya', $customer->getFirstName());
    }
    
    protected function getHttpClientMock($content)
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $response->expects($this->once())->method('getStatusCode')->willReturn(200);
        $response->expects($this->once())->method('getContent')->willReturn($content);
        $httpClient->expects($this->once())->method('request')->willReturn($response);
        
        return $httpClient;
    }
    
    protected function createMockObject(string $class)
    {
        return $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->em->close();
        unset($this->em);
    }
}