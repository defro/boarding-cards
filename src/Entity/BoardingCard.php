<?php

namespace App\Entity;

use App\Enum\Transportation;

abstract class BoardingCard
{
    private Transportation $transportation;

    /**
     * @return Transportation
     */
    public function getTransportation(): Transportation
    {
        return $this->transportation;
    }

    /**
     * @param Transportation $transportation
     * @return self
     */
    public function setTransportation(Transportation $transportation): self
    {
        $this->transportation = $transportation;
        return $this;
    }

    private ?string $transportationIdentification;

    /**
     * @return string|null
     * @return self
     */
    public function getTransportationIdentification(): ?string
    {
        return $this->transportationIdentification;
    }

    /**
     * @param string|null $transportationIdentification
     */
    public function setTransportationIdentification(?string $transportationIdentification): self
    {
        $this->transportationIdentification = $transportationIdentification;
        return $this;
    }

    private string $departure;

    /**
     * @return string
     */
    public function getDeparture(): string
    {
        return $this->departure;
    }

    /**
     * @param string $departure
     * @return self
     */
    public function setDeparture(string $departure): self
    {
        $this->departure = $departure;
        return $this;
    }

    private string $arrival;

    /**
     * @return string
     */
    public function getArrival(): string
    {
        return $this->arrival;
    }

    /**
     * @param string $arrival
     * @return self
     */
    public function setArrival(string $arrival): self
    {
        $this->arrival = $arrival;
        return $this;
    }

    private ?string $seat;

    /**
     * @return string|null
     */
    public function getSeat(): ?string
    {
        return $this->seat;
    }

    /**
     * @param string|null $seat
     * @return self
     */
    public function setSeat(?string $seat): self
    {
        $this->seat = $seat;
        return $this;
    }

    private ?string $gate;

    /**
     * @return string|null
     */
    public function getGate(): ?string
    {
        return $this->gate;
    }

    /**
     * @param string|null $gate
     * @return self
     */
    public function setGate(?string $gate): self
    {
        $this->gate = $gate;
        return $this;
    }

    private ?string $luggageTag;

    /**
     * @return string|null
     */
    public function getLuggageTag(): ?string
    {
        return $this->luggageTag;
    }

    /**
     * @param string|null $luggageTag
     * @return self
     */
    public function setLuggageTag(?string $luggageTag): self
    {
        $this->luggageTag = $luggageTag;
        return $this;
    }
}
