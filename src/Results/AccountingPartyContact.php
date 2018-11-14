<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingPartyContact extends Entity
{
    protected $fields = [
        'Name'      => ['value' => null, 'type' => 'string'],
        'Telephone' => ['value' => null, 'type' => 'string']
    ];
}