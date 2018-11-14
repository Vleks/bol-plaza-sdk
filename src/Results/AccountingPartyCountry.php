<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingPartyCountry extends Entity
{
    protected $fields = [
        'IdentificationCode' => [
            'value'      => null,
            'type'       => 'string',
            'parameters' => [
                'listID'       => ['value' => null, 'type' => 'string'],
                'listAgencyID' => ['value' => null, 'type' => 'int']
            ]
        ]
    ];
}