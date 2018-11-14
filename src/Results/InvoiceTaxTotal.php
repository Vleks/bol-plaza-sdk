<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceTaxTotal extends Entity
{
    protected $fields = [
        'TaxAmount'   => [
            'value'      => null,
            'type'       => 'float',
            'properties' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxSubtotal' => [
            'ns'    => 'ns3:',
            'value' => [],
            'type'  => [InvoiceTaxSubTotal::class]
        ]
    ];
}