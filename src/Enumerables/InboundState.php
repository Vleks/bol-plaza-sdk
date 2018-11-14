<?php
namespace Vleks\BolPlazaSDK\Enumerables;

class InboundState extends Enumerable
{
    const DRAFT        = 'Draft';
    const PREANNOUNCED = 'PreAnnounced';
    const ARRIVEDATWH  = 'ArrivedAtWH';
    const CANCELLED    = 'Cancelled';
}
