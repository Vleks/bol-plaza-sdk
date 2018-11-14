<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingPartyIdentification extends Entity
{
    protected $fields = [
        'ID' => [
            'value'      => null,
            'type'       => 'string',
            'parameters' => [
                'schemeID' => ['value' => null, 'type' => 'string']
            ]
        ]
    ];
}