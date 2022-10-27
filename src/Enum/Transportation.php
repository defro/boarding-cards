<?php

namespace App\Enum;

enum Transportation: string
{
    case Train = 'train';
    case AirportBus = 'airport bus';
    case Flight = 'flight';
}
