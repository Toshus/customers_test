<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

class UserLoader
{
    private HttpClientInterface $httpClient;
    private string $userApiBaseUri;
    private DenormalizerInterface $denormalizer;
    private CustomerService $customerService;
    
    public function __construct(
        HttpClientInterface $httpClient,
        DenormalizerInterface $denormalizer,
        CustomerService $customerService,
        string $userApiBaseUri
    )
    {
        $this->httpClient = $httpClient;
        $this->denormalizer = $denormalizer;
        $this->userApiBaseUri = $userApiBaseUri;
        $this->customerService = $customerService;
    }
    
    public function loadUsers(array $params)
    {
        $users = $this->getUsersData($params);
        $customers = $this->denormalizer->denormalize($users, Customer::class);
        
        array_walk($customers, function (Customer $customer) {
            $this->customerService->insertOrUpdateCustomer($customer);
        });
    }
    
    private function getUsersData(array $params): array
    {
        try {
            $response = $this->httpClient->request(
                'GET',
                $this->userApiBaseUri,
                [
                    'query' => $params,
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]
            );
            if ($response->getStatusCode() === Response::HTTP_OK) {
                $data = json_decode($response->getContent(), true);
                return $data['results'] ?? [];
            } else {
                throw new Exception(sprintf(
                    'Can\'t get users from API (%s). Response code: %s',
                    $this->userApiBaseUri,
                    $response->getStatusCode()
                ));
            }
        } catch (Throwable $e) {
            throw new Exception(sprintf(
                'Can\'t get users from API (%s). Error: %s',
                $this->userApiBaseUri,
                $e->getMessage()
            ));
        }
    }
}
