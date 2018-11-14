<?php
namespace Vleks\BolPlazaSDK\Entities;

use Vleks\BolPlazaSDK\Entity;

class TimeSlot extends Entity
{
    protected $fields = [
        'Start' => ['value' => null, 'type' => 'DateTime'],
        'End'   => ['value' => null, 'type' => 'DateTime']
    ];
}
