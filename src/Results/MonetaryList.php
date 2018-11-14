<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class MonetaryList extends Entity
{
    protected $fields = [
        'LineExtensionAmount' => ['value' => null, 'type' => Monetary::class],
        'TaxExclusiveAmount'  => ['value' => null, 'type' => Monetary::class],
        'TaxInclusiveAmount'  => ['value' => null, 'type' => Monetary::class],
        'PayableAmount'       => ['value' => null, 'type' => Monetary::class]
    ];
}