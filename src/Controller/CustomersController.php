<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomersController extends AbstractController
{
    const CUSTOMER_LIMIT = 10;
    
    /**
     * @Route("/customer", name="customer-list", methods={"GET"})
     */
    public function getCustomersList(Request $request, CustomerRepository $customerRepository)
    {
        $limit = $request->get('limit', self::CUSTOMER_LIMIT);
        if (!is_numeric($limit) || (int)$limit < 0) {
            throw new BadRequestException('Limit must be an integer positive value');
        }
        
        $offset = $request->get('offset', 0);
        if (!is_numeric($offset) || (int)$offset < 0) {
            throw new BadRequestException('Offset must be an integer positive value');
        }
        
        $result = $customerRepository->getList((int)$limit, (int)$offset);
        $total = $customerRepository->getTotalCount();
        
        return $this->json(compact('total', 'result'), Response::HTTP_OK, [], ['groups' => ['list']]);
    }
    
    /**
     * @Route("/customer/{id}", name="customer", methods={"GET"})
     */
    public function getCustomer(Customer $customer)
    {
        return $this->json(['result' => $customer], Response::HTTP_OK, [], ['groups' => ['customer']]);
    }
}