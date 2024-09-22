<?php 
    require_once 'src/TimeCalculator.php';
    class TimeCalculatorTest extends \PHPUnit\Framework\TestCase {
        public function testValidateTimeInput() {
            $result = validateTimeInput('00:14');
            $this->assertEquals(false, $result);
        }

        public function testCalculateDayAndNightTime() {
            $resultStartDayEndDay = ['day' => 15.75, 'night' => 0];
            $resultStartNightEndNight = ['day' => 16.0, 'night' => 6.0];
            $resultStartNighEndDay = ['day' => 0.25, 'night' => 6.5];
            $resultStartDayEndNight = ['day' => 15.5, 'night' => 2.25];
            $resultStartAftherEnd = ['day' => 16.0, 'night' => 7.75];

            $StartDayEndDay = calculateDayAndNightTime('06:15','22:00');
            $StartNightEndNight = calculateDayAndNightTime('00:15','22:15');
            $StartNighEndDay = calculateDayAndNightTime('23:30','06:15');
            $StartDayEndNight = calculateDayAndNightTime('06:30','00:15');
            $StartAftherEnd = calculateDayAndNightTime('00:30','00:15');

            $this->assertSame( $resultStartDayEndDay, $StartDayEndDay);
            $this->assertSame( $resultStartNightEndNight, $StartNightEndNight);
            $this->assertSame( $resultStartNighEndDay, $StartNighEndDay);
            $this->assertSame( $resultStartDayEndNight, $StartDayEndNight);
            $this->assertSame( $resultStartAftherEnd, $StartAftherEnd);

        }
    }
?>