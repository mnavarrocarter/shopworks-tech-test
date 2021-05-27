<?php

namespace Shopworks;

use Cake\Chronos\Chronos;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Shopworks\Model\Rota;
use Shopworks\Model\Shift;
use Shopworks\Model\Staff;

/**
 * Class BasicSingleManningCalculatorTest
 * @package Shopworks
 */
class BasicSingleManningCalculatorTest extends TestCase
{
    public function testCaseOne(): void
    {
        $calculator = new BasicSingleManningCalculator();
        $rota = new Rota(Uuid::uuid4(), Chronos::now()->startOfWeek());

        // Given Black Widow working at FunHouse on Monday in one long shift
        $staff = new Staff(Uuid::uuid4(), 'Black Widow');
        $start = $rota->getWeekStartDate()->setTime(9, 0);
        $end = $start->addHour(8);
        $rota->addShift(new Shift(Uuid::uuid4(), $staff, $start, $end));

        // And no-one else works during the day

        // Then Black Widow receives single manning supplement for the whole duration of her shift
        $singleManning = $calculator->calculate($rota);
        self::assertSame(480, $singleManning->getStaffTimeForDay(Chronos::MONDAY, $staff->getId()->toString()));
    }

    public function testCaseTwo(): void
    {
        $calculator = new BasicSingleManningCalculator();
        $rota = new Rota(Uuid::uuid4(), Chronos::now()->startOfWeek());

        // Given Black Widow and Thor working at FunHouse on Tuesday
        $blackWidow = new Staff(Uuid::uuid4(), 'Black Widow');
        $thor = new Staff(Uuid::uuid4(), 'Thor');
        $tuesday = $rota->getWeekStartDate()->addDay();

        // When they only meet at the door to say hi and bye
        $start = $tuesday->setTime(9, 0);
        $end = $start->addHour(5);
        $rota->addShift(new Shift(Uuid::uuid4(), $blackWidow, $start, $end));
        $start = $tuesday->setTime(9, 0)->addHour(5);
        $end = $start->addHour(5);
        $rota->addShift(new Shift(Uuid::uuid4(), $thor, $start, $end));

        // Then Black Widow receives single manning supplement for the whole duration of her shift
        $singleManning = $calculator->calculate($rota);
        self::assertSame(300, $singleManning->getStaffTimeForDay(Chronos::TUESDAY, $blackWidow->getId()->toString()));
        // And Thor also receives single manning supplement for the whole duration of his shift.
        self::assertSame(300, $singleManning->getStaffTimeForDay(Chronos::TUESDAY, $blackWidow->getId()->toString()));
    }

    public function testCaseThree(): void
    {
        $calculator = new BasicSingleManningCalculator();
        $rota = new Rota(Uuid::uuid4(), Chronos::now()->startOfWeek());

        // Given Wolverine and Gamora working at FunHouse on Wednesday
        $wolverine = new Staff(Uuid::uuid4(), 'Wolverine');
        $gamorra = new Staff(Uuid::uuid4(), 'Gamora');
        $wednesday = $rota->getWeekStartDate()->addDays(2);

        // When Wolverine works in the morning shift
        $start = $wednesday->setTime(9, 0);
        $end = $start->addHour(5);
        $rota->addShift(new Shift(Uuid::uuid4(), $wolverine, $start, $end));
        // And Gamora works the whole day, starting slightly later than Wolverine
        $start = $wednesday->setTime(11, 0);
        $end = $start->setTime(18, 0);
        $rota->addShift(new Shift(Uuid::uuid4(), $gamorra, $start, $end));


        $singleManning = $calculator->calculate($rota);
        // Then Wolverine receives single manning supplement until Gamorra starts her shift (2 hours)
        self::assertSame(120, $singleManning->getStaffTimeForDay(Chronos::WEDNESDAY, $wolverine->getId()->toString()));
        // And Gamorra receives single manning supplement starting when Wolverine has finished his shift, until the end of the day (4 hours)
        self::assertSame(240, $singleManning->getStaffTimeForDay(Chronos::WEDNESDAY, $gamorra->getId()->toString()));
    }
}
