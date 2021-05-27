<?php


namespace Shopworks;

use Shopworks\Model\WorkPeriod;

/**
 * Class SingleManning
 * @package Shopworks
 */
class SingleManning
{
    /**
     * @var array<int,array<string,int>>
     */
    private array $data;

    /**
     * SingleManning constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * @param WorkPeriod[] $periods
     */
    public static function fromPeriods(array $periods): SingleManning
    {
        $manning = new self();
        foreach ($periods as $period) {
            $day = $period->getStart()->dayOfWeek;
            $staffId = $period->getStaff()->getId()->toString();
            $minutes = $manning->data[$day][$staffId] ?? 0;
            $minutes += $period->getDuration();
            $manning->data[$day][$staffId] = $minutes;
        }
        return $manning;
    }

    /**
     * @param int $day
     * @return array
     */
    public function getEntriesForDay(int $day): array
    {
        return $this->data[$day] ?? [];
    }

    /**
     * @param int $day
     * @return int
     */
    public function getTotalAloneTimeForDay(int $day): int
    {
        return array_sum($this->getEntriesForDay($day));
    }

    /**
     * @param int $day
     * @param string $staffId
     * @return int
     */
    public function getStaffTimeForDay(int $day, string $staffId): int
    {
        return $this->data[$day][$staffId] ?? 0;
    }
}