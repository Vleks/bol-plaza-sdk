<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceTaxSubTotal extends Entity
{
    protected $fields = [
        'TaxableAmount' => [
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxAmount'     => [
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxCategory'   => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceTaxCategory::class
        ]
    ];
}