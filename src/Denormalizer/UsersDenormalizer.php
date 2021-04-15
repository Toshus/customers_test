<?php

declare(strict_types=1);

namespace App\Denormalizer;

use App\Entity\Customer;
use DateTime;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UsersDenormalizer implements DenormalizerInterface
{
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $customers = [];
        
        array_walk($data, function (array &$customerData) use ($customers) {
            $customerData['nameTitle'] = $customerData['name']['title'];
            $customerData['firstName'] = $customerData['name']['first'];
            $customerData['lastName'] = $customerData['name']['last'];
            unset($customerData['name']);
            
            $customerData['street'] = $customerData['location']['street']['number'] . ', ' . $customerData['location']['street']['name'];
            $customerData['city'] = $customerData['location']['city'];
            $customerData['state'] = $customerData['location']['state'];
            $customerData['country'] = $customerData['location']['country'];
            $customerData['postcode'] = (int)$customerData['location']['postcode'];
            $customerData['latitude'] = $customerData['location']['coordinates']['latitude'];
            $customerData['longitude'] = $customerData['location']['coordinates']['longitude'];
            $customerData['timezoneOffset'] = $customerData['location']['timezone']['offset'];
            $customerData['timezoneDescription'] = $customerData['location']['timezone']['description'];
            unset($customerData['location']);
            
            $customerData['uuid'] = $customerData['login']['uuid'];
            $customerData['username'] = $customerData['login']['username'];
            $customerData['password'] = $customerData['login']['password'];
            $customerData['salt'] = $customerData['login']['salt'];
            $customerData['hashmd5'] = $customerData['login']['md5'];
            $customerData['hashsha1'] = $customerData['login']['sha1'];
            $customerData['hashsha256'] = $customerData['login']['sha256'];
            unset($customerData['login']);
            
            $customerData['birthday'] = new DateTime($customerData['dob']['date']);
            unset($customerData['dob']);
            
            $customerData['registered'] = new DateTime($customerData['registered']['date']);
            
            $customerData['idName'] = $customerData['id']['name'];
            $customerData['idValue'] = $customerData['id']['value'];
            unset($customerData['id']);
            
            $customerData['pictureLg'] = $customerData['picture']['large'];
            $customerData['pictureMed'] = $customerData['picture']['medium'];
            $customerData['pictureThumb'] = $customerData['picture']['thumbnail'];
            unset($customerData['picture']);
            
            $customerData['nationality'] = $customerData['nat'];
            unset($customerData['nat']);
            
            $customer = new Customer();
            array_walk($customerData, function ($value, $key) use ($customer) {
                $funcName = 'set' . ucfirst($key);
                $customer->$funcName($value);
            });
            $customerData = $customer;
        });
        return $data;
    }
    
    public function supportsDenormalization($data, string $type, string $format = null): bool
    {
        return $type === Customer::class;
    }
}