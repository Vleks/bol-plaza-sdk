<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class CustomerDetail extends Entity
{
    protected $fields = [
        'SalutationCode'      => ['value' => null, 'type' => 'string'],
        'Firstname'           => ['value' => null, 'type' => 'string'],
        'Surname'             => ['value' => null, 'type' => 'string'],
        'Streetname'          => ['value' => null, 'type' => 'string'],
        'Housenumber'         => ['value' => null, 'type' => 'string'],
        'HousenumberExtended' => ['value' => null, 'type' => 'string'],
        'ZipCode'             => ['value' => null, 'type' => 'string'],
        'City'                => ['value' => null, 'type' => 'string'],
        'CountryCode'         => ['value' => null, 'type' => 'string'],
        'Email'               => ['value' => null, 'type' => 'string'],
        'Company'             => ['value' => null, 'type' => 'string']
    ];
}
