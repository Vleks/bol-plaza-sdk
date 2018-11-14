<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecificationItemClassifiedTaxCategoryTaxScheme extends Entity
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
        ]
    ];
}
