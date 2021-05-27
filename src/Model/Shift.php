<?php


namespace Shopworks\Model;

use Cake\Chronos\Chronos;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Shift
 * @package Shopworks
 */
class Shift
{
    private UuidInterface $id;
    private Staff $staff;
    private Chronos $startTime;
    private Chronos $endTime;
    /**
     * @var ShiftBreak[]
     */
    private array $breaks;

    /**
     * Shift constructor.
     * @param UuidInterface $id
     * @param Staff $staff
     * @param Chronos $startTime
     * @param Chronos $endTime
     */
    public function __construct(UuidInterface $id, Staff $staff, Chronos $startTime, Chronos $endTime)
    {
        $this->id = $id;
        $this->staff = $staff;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->breaks = [];
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return Staff
     */
    public function getStaff(): Staff
    {
        return $this->staff;
    }

    /**
     * @return Chronos
     */
    public function getStartTime(): Chronos
    {
        return $this->startTime;
    }

    /**
     * @return Chronos
     */
    public function getEndTime(): Chronos
    {
        return $this->endTime;
    }

    /**
     * @param ShiftBreak $break
     */
    public function addBreak(ShiftBreak $break): void
    {
        if (!$break->getStartTime()->between($this->startTime, $this->endTime)) {
            throw new \InvalidArgumentException("Break start time is not inside the shift time");
        }
        if (!$break->getEndTime()->between($this->startTime, $this->endTime)) {
            throw new \InvalidArgumentException("Break end time is not inside the shift time");
        }
        $this->breaks[] = $break;
    }

    /**
     * @return ShiftBreak[]
     */
    public function getBreaks(): array
    {
        return $this->breaks;
    }
}