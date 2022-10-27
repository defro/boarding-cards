<?php

namespace App\Entity;

use App\Interfaces\BoardingCardInterface;

class Flight extends BoardingCard implements BoardingCardInterface
{
    public function __toString(): string
    {
        $string = sprintf(
            'From %s, take %s %s to %s. Gate %s, seat %s. ',
            $this->getDeparture(),
            $this->getTransportation()->value,
            $this->getTransportationIdentification(),
            $this->getArrival(),
            $this->getGate(),
            $this->getSeat(),
        );

        if ($this->getLuggageTag()) {
            $string .= sprintf('Baggage drop at ticket counter %s.', $this->getLuggageTag());
        }
        else {
            $string .= 'Baggage will we automatically transferred from your last leg.';
        }

        return $string;
    }
}
