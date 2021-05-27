<?php


namespace Shopworks;

use Shopworks\Model\Rota;

/**
 * Interface SingleManningCalculator
 * @package Shopworks
 */
interface SingleManningCalculator
{
    /**
     * @param Rota $rota
     * @return SingleManning
     */
    public function calculate(Rota $rota): SingleManning;
}