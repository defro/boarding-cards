<?php

namespace App\Entity;

use App\Interfaces\BoardingCardInterface;

class AirportBus extends BoardingCard implements BoardingCardInterface
{
    public function __toString(): string
    {
        $string = sprintf(
            'Take the %s from %s to %s. ',
            $this->getTransportation()->value,
            $this->getDeparture(),
            $this->getArrival(),
        );

        if ($this->getSeat()) {
            $string .= sprintf('Sit in %s.', $this->getSeat());
        }
        else {
            $string .= 'No seat assignment.';
        }

        return $string;
    }
}
