<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecifications extends Entity
{
    protected $fields = [
        'InvoiceSpecification' => ['ns' => '', 'value' => [], 'type' => [InvoiceSpecification::class]]
    ];
}
