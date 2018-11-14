<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceLineItem extends Entity
{
    protected $fields = [
        'Description'           => ['value' => null, 'type' => 'string'],
        'Name'                  => ['value' => null, 'type' => 'string'],
        'ClassifiedTaxCategory' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceTaxCategory::class
        ]
    ];
}