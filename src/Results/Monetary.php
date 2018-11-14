<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class Monetary extends Entity
{
    protected $fields = [
        'Amount'     => ['value' => null, 'type' => 'float'],
        'CurrencyID' => ['value' => null, 'type' => 'string']
    ];
}