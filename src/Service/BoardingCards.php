<?php

namespace App\Service;

use App\Exception\TripException;
use App\Interfaces\BoardingCardInterface;

class BoardingCards
{
    /** @var array<BoardingCardInterface>  */
    private array $boardingCards = [];

    /**
     * @return array<BoardingCardInterface>
     */
    public function getBoardingCards(): array
    {
        return $this->boardingCards;
    }

    /**
     * @param array $boardingCards
     * @return self
     */
    public function setBoardingCards(array $boardingCards): self
    {
        $this->boardingCards = $boardingCards;
        return $this;
    }

    /**
     * @param BoardingCardInterface $boardingCard
     * @return self
     */
    public function addBoardingCard(BoardingCardInterface $boardingCard): self
    {
        $this->boardingCards[] = $boardingCard;
        return $this;
    }

    public function getStart(): string
    {
        $departures = array_map(function (BoardingCardInterface $boardingCard) : string {
            return $boardingCard->getDeparture();
        }, $this->getBoardingCards());
        $arrivals = array_map(function (BoardingCardInterface $boardingCard) : string {
            return $boardingCard->getArrival();
        }, $this->getBoardingCards());

        $start = array_diff($departures, $arrivals);
        if (count($start) !== 1) {
            throw new TripException(sprintf(
                'More than one start point found: %s', implode(' | ', $start)
            ));
        }

        return current($start);
    }

    public function findByDeparture(string $departure) : ?BoardingCardInterface
    {
        $card = array_filter($this->getBoardingCards(), function(BoardingCardInterface $card) use ($departure) : bool {
            return $card->getDeparture() === $departure;
        });

        return empty($card) ? null : current($card);
    }
}
