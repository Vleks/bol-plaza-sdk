<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingPartyLegalEntity extends Entity
{
    protected $fields = [
        'CompanyID' => [
            'value'      => null,
            'type'       => 'int',
            'parameters' => [
                'schemeID'       => ['value' => null, 'type' => 'string'],
                'schemeAgencyID' => ['value' => null, 'type' => 'string']
            ]
        ]
    ];
}