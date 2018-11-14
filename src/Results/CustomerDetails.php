<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class CustomerDetails extends Entity
{
    protected $fields = [
        'ShipmentDetails' => ['value' => null, 'type' => CustomerDetail::class],
        'BillingDetails'  => ['value' => null, 'type' => CustomerDetail::class]
    ];
}
