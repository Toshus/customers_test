<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class CustomerService
{
    private EntityManagerInterface $em;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }
    
    public function insertOrUpdateCustomer(Customer $customer)
    {
        try {
            $this->em->persist($customer);
            $this->em->flush();
        } catch (Throwable $e) {
            $customerRepository = $this->em->getRepository(Customer::class);
            $oldCustomer = $customerRepository->findOneBy(['email' => $customer->getEmail()]);
            if (!$oldCustomer) {
                throw $e;
            }

            foreach ($customer->toArray() as $key => $val) {
                if ('id' === $key) {
                    continue;
                }
                $funcName = 'set' . ucfirst($key);
                $oldCustomer->$funcName($val);
            }
            $this->em->persist($oldCustomer);
            $this->em->flush();
        }
    }
}