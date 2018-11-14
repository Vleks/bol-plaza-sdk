<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecificationItemClassifiedTaxCategory extends Entity
{
    protected $fields = [
        'ID'        => [
            'ns'    => 'ns2:',
            'value' => null,
            'type'  => 'string',
            'parameters' => [
                'schemeID'       => ['value' => null, 'type' => 'string'],
                'schemeAgencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'Percent'   => [
            'ns'    => 'ns2:',
            'value' => null,
            'type'  => 'float'
        ],
        'TaxScheme' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceSpecificationItemClassifiedTaxCategoryTaxScheme::class
        ]
    ];
}
