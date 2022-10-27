<?php

namespace App\Entity;

use App\Interfaces\BoardingCardInterface;

class Train extends BoardingCard implements BoardingCardInterface
{
    public function __toString(): string
    {
        $string = sprintf(
            'Take %s %s from %s to %s. ',
            $this->getTransportation()->value,
            $this->getTransportationIdentification(),
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
