<?php 
    require_once 'src/TimeCalculator.php';
    class TimeCalculatorTest extends \PHPUnit\Framework\TestCase {
        public function testValidateTimeInput() {
            $result = validateTimeInput('00:14');
            $this->assertEquals(false, $result);
        }
    }
?>