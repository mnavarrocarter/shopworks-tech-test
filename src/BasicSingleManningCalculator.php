<?php


namespace Shopworks;

use Shopworks\Model\WorkPeriod;
use Shopworks\Model\Rota;

/**
 * Class BasicSingleManningCalculator
 * @package Shopworks
 */
final class BasicSingleManningCalculator implements SingleManningCalculator
{
    /**
     * @param Rota $rota
     * @return SingleManning
     */
    public function calculate(Rota $rota): SingleManning
    {
        // First, we get all the shifts.
        $shifts = $rota->getShifts();
        /** @var WorkPeriod[] $periods */

        $periods = [];
        foreach ($shifts as $shift) {
            // We create the current period from the shift info
            $current = WorkPeriod::fromShift($shift);

            // If the periods are empty, then we put the current one and continue.
            if ($periods === []) {
                $periods[] = $current;
                continue;
            }
            // If there are previously stored periods, we need to calculate the
            // diff with the current period.
            $newPeriods = [];
            foreach ($periods as $period) {
                $newPeriods[] = $period->diff($current);
            }
            $periods = array_merge(...$newPeriods);
        }
        return SingleManning::fromPeriods($periods);
    }
}