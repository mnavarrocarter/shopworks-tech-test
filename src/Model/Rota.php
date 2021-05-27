<?php


namespace Shopworks\Model;

use Cake\Chronos\Chronos;
use InvalidArgumentException;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Rota
 * @package Shopworks
 */
class Rota
{
    private UuidInterface $id;
    private Chronos $weekStartDate;
    /**
     * @var Shift[]
     */
    private array $shifts;

    /**
     * Rota constructor.
     * @param UuidInterface $id
     * @param Chronos $weekStartDate
     */
    public function __construct(UuidInterface $id, Chronos $weekStartDate)
    {
        $this->id = $id;
        $this->weekStartDate = $weekStartDate;
        $this->shifts = [];
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return Chronos
     */
    public function getWeekStartDate(): Chronos
    {
        return $this->weekStartDate;
    }

    /**
     * @param Shift $shift
     */
    public function addShift(Shift $shift): void
    {
        if (!$shift->getStartTime()->between($this->weekStartDate, $this->weekStartDate->addWeek())) {
            throw new InvalidArgumentException("Shift's start time is not inside the Rota's week");
        }
        if (!$shift->getEndTime()->between($this->weekStartDate, $this->weekStartDate->addWeek())) {
            throw new InvalidArgumentException("Shift's end time is not inside the Rota's week");
        }
        $this->shifts[] = $shift;
    }

    /**
     * @return Shift[]
     */
    public function getShifts(): array
    {
        return $this->shifts;
    }
}