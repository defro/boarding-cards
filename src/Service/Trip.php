<?php

namespace App\Service;

use App\Entity\AirportBus;
use App\Entity\Flight;
use App\Entity\Train;
use App\Enum\Transportation;
use App\Exception\TripException;

class Trip
{
    /** @var array */
    private array $json;

    /** @var BoardingCards */
    private BoardingCards $boardingCards;

    /**
     * @throws TripException
     */
    public function __construct(string $json)
    {
        $json = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new TripException(json_last_error_msg(), json_last_error());
        }

        $this->json = $json;

        $this->boardingCards = new BoardingCards();
        $this->boardingCards->setBoardingCards([]); // reset
    }

    public function run() : string
    {
        if (empty($this->json)) {
            return 'None boarding cards has been supplied.';
        }

        foreach ($this->json as $index => $item) {
            if (empty($item['transportation'])) {
                throw new TripException(sprintf(
                    'No transportation found for item at index %d.', $index
                ));
            }
            if (empty($item['departure'])) {
                throw new TripException(sprintf(
                    'No departure found for item at index %d.', $index
                ));
            }
            if (empty($item['arrival'])) {
                throw new TripException(sprintf(
                    'No arrival found for item at index %d.', $index
                ));
            }

            $transportation = Transportation::tryFrom($item['transportation']);
            if (null === $transportation) {
                throw new TripException(sprintf(
                    'Transportation "%s" is unknown.', $item['transportation']
                ));
            }

            $className = sprintf('\App\Entity\%s', $transportation->name);
            if (true !== class_exists($className)) {
                throw new TripException(sprintf(
                    'Class "%s" has not be found.', $className
                ));
            }

            match ($transportation) {
                Transportation::AirportBus => $this->addAirportBus($item),
                Transportation::Train => $this->addTrain($item),
                Transportation::Flight => $this->addFlight($item),
                default => throw new TripException(sprintf(
                    'Transportation %s not found.', $transportation->value
                )),
            };
        }

        $boardingCards = $this->sort();

        $return = '';
        foreach ($boardingCards as $item) {
            $return .= sprintf('%s%s', $item, PHP_EOL);
        }
        $return .= sprintf('You have arrived at your final destination.%s', PHP_EOL);

        return $return;
    }

    private function sort() {
        $step = $this->boardingCards->getStart();

        $sorted = new BoardingCards();
        do {
            $boardingCard = $this->boardingCards->findByDeparture($step);
            if (null !== $boardingCard) {
                $sorted->addBoardingCard($boardingCard);
                $step = $boardingCard->getArrival();
            }
        } while($boardingCard);

        return $sorted->getBoardingCards();
    }

    private function addFlight(array $item) {
        if (empty($item['transportationIdentification'])) {
            throw new TripException('No transportation identification found for flight.');
        }
        if (empty($item['seat'])) {
            throw new TripException('No seat found for flight.');
        }
        if (empty($item['gate'])) {
            throw new TripException('No gate found for flight.');
        }

        $class = new Flight();
        $class
            ->setTransportation(Transportation::Flight)
            ->setTransportationIdentification($item['transportationIdentification'])
            ->setDeparture($item['departure'])
            ->setArrival($item['arrival'])
            ->setSeat($item['seat'])
            ->setGate($item['gate'])
            ->setLuggageTag($item['luggageTag'] ?? null)
        ;
        return $this->boardingCards->addBoardingCard($class);
    }

    private function addTrain(array $item) {
        $class = new Train();
        $class
            ->setTransportation(Transportation::Train)
            ->setTransportationIdentification($item['transportationIdentification'] ?? null)
            ->setDeparture($item['departure'])
            ->setArrival($item['arrival'])
            ->setSeat($item['seat'] ?? null)
        ;
        return $this->boardingCards->addBoardingCard($class);
    }

    private function addAirportBus(array $item) {
        $class = new AirportBus();
        $class
            ->setTransportation(Transportation::AirportBus)
            ->setDeparture($item['departure'])
            ->setArrival($item['arrival'])
            ->setSeat($item['seat'] ?? null)
        ;
        return $this->boardingCards->addBoardingCard($class);
    }
}
