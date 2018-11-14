<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;
use Vleks\BolPlazaSDK\Entities\TimeSlot;

class DeliveryWindowResult extends Entity
{
    protected $fields = [
        'TimeSlot' => ['value' => [], 'type'  => [TimeSlot::class]]
    ];
}
