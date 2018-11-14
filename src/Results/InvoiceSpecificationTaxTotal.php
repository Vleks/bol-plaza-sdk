<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecificationTaxTotal extends Entity
{
    protected $fields = [
        'TaxAmount' => [
            'ns'         => 'ns2:',
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ]
    ];
}
