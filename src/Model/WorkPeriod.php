<?php


namespace Shopworks\Model;

use Cake\Chronos\Chronos;

/**
 * Class WorkPeriod
 * @package Shopworks\Model
 */
class WorkPeriod
{
    private Staff $staff;
    private Chronos $start;
    private Chronos $end;

    /**
     * @param Shift $shift
     * @return WorkPeriod
     */
    public static function fromShift(Shift $shift): WorkPeriod
    {
        return new self(
            $shift->getStaff(),
            $shift->getStartTime(),
            $shift->getEndTime()
        );
    }

    /**
     * WorkPeriod constructor.
     * @param Staff $staff
     * @param Chronos $start
     * @param Chronos $end
     */
    public function __construct(Staff $staff, Chronos $start, Chronos $end)
    {
        $this->staff = $staff;
        $this->start = $start;
        $this->end = $end;
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
    public function getStart(): Chronos
    {
        return $this->start;
    }

    /**
     * @return Chronos
     */
    public function getEnd(): Chronos
    {
        return $this->end;
    }

    /**
     * @param WorkPeriod $period
     * @return array
     */
    public function diff(WorkPeriod $period): array
    {
        // If a does not overlap with b, we return both unchanged
        if (!$period->touches($this)) {
            return [$this, $period];
        }
        // If a contains b, we split a in two
        if ($this->contains($period)) {
            $a = clone $this;
            $a->end = $period->start;
            $b = clone $this;
            $b->start = $period->end;
            return [$a, $b];
        }
        // If b contains a, we split b in two
        if ($period->contains($this)) {
            $a = clone $period;
            $a->end = $this->start;
            $b = clone $period;
            $b->start = $this->end;
            return [$a, $b];
        }
        // If a starts inside b, we trim a and b.
        if ($this->startsInside($period) && !$this->endsInside($period)) {
            $b = clone $period;
            $b->end = $this->start;
            $a = clone $this;
            $a->start = $period->end;
            return [$b, $a];
        }
        // If b starts inside a, we trim a and b.
        if ($period->startsInside($this) && !$period->endsInside($this)) {
            $a = clone $this;
            $a->end = $period->start;
            $b = clone $period;
            $b->start = $this->end;
            return [$a, $b];
        }
        throw new \RuntimeException('Invalid case');
    }

    public function getDuration(): int
    {
        return $this->start->diffInMinutes($this->end);
    }

    /**
     * @param WorkPeriod $period
     * @return bool
     */
    public function touches(WorkPeriod $period): bool
    {
        return $this->startsInside($period) || $this->endsInside($period);
    }

    /**
     * @param WorkPeriod $period
     * @return bool
     */
    public function contains(WorkPeriod $period): bool
    {
        return $this->start >= $period->start && $this->end <= $period->end;
    }

    public function startsInside(WorkPeriod $period): bool
    {
        return $this->start->between($period->start, $period->end);
    }

    public function endsInside(WorkPeriod $period): bool
    {
        return $this->end->between($period->start, $period->end);
    }
}