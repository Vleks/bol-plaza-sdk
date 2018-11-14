<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;
use Vleks\BolPlazaSDK\Entities\FbbTransporter;

class FbbTransporterResult extends Entity
{
    protected $fields = [
        'FbbTransporter' => ['value' => [], 'type'  => [FbbTransporter::class]]
    ];
}
