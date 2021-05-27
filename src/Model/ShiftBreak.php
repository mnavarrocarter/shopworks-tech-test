<?php


namespace Shopworks\Model;

use Cake\Chronos\Chronos;
use Ramsey\Uuid\UuidInterface;

/**
 * Class ShiftBreak
 * @package Shopworks
 */
class ShiftBreak
{
    private UuidInterface $id;
    private Chronos $startTime;
    private Chronos $endTime;

    /**
     * Breaks constructor.
     * @param UuidInterface $id
     * @param Chronos $startTime
     * @param Chronos $endTime
     */
    public function __construct(UuidInterface $id, Chronos $startTime, Chronos $endTime)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
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
}