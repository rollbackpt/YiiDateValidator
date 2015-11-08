<?php
class DateValidatorTest extends PHPUnit_Framework_TestCase
{
    public $dateValidator;

    public function testValidateMonthYear()
    {
        $this->dateValidator = new \DateValidator\DateValidator('m-Y', '01-1950', '01-2020', '/^\d{1,2}-\d{4}$/');

        $this->assertEquals(true, $this->dateValidator->validate("01-2012"));
        $this->assertEquals(true, $this->dateValidator->validate("06-1950"));
        $this->assertEquals(true, $this->dateValidator->validate("12-2019"));
        $this->assertEquals(false, $this->dateValidator->validate("00-2019"));
        $this->assertEquals(false, $this->dateValidator->validate("01-06-2050"));
        $this->assertEquals(false, $this->dateValidator->validate("01-12-1800"));
        $this->assertEquals(false, $this->dateValidator->validate("2020-01-02"));
        $this->assertEquals(false, $this->dateValidator->validate("4h35jkh4h"));
        $this->assertEquals(false, $this->dateValidator->validate("01-0001"));
        $this->assertEquals(false, $this->dateValidator->validate("00-0000"));
        $this->assertEquals(false, $this->dateValidator->validate("01-1920"));
        $this->assertEquals(false, $this->dateValidator->validate("06-2030"));
        $this->assertEquals(false, $this->dateValidator->validate("14-2000"));
        $this->assertEquals(false, $this->dateValidator->validate("10-200"));
        $this->assertEquals(false, $this->dateValidator->validate("10-19999"));
        $this->assertEquals(false, $this->dateValidator->validate(""));
        $this->assertEquals(true, $this->dateValidator->validate("6-2019"));
    }

    public function testValidateFullDate()
    {
        $this->dateValidator = new \DateValidator\DateValidator('d-m-Y', '01-01-1950', '01-01-2020', '/^\d{1,2}-\d{1,2}-\d{4}$/');

        $this->assertEquals(true, $this->dateValidator->validate("01-01-2012"));
        $this->assertEquals(true, $this->dateValidator->validate("01-02-1950"));
        $this->assertEquals(true, $this->dateValidator->validate("12-12-2019"));
        $this->assertEquals(false, $this->dateValidator->validate("00-00-2019"));
        $this->assertEquals(false, $this->dateValidator->validate("00-01-2019"));
        $this->assertEquals(false, $this->dateValidator->validate("01-2012"));
        $this->assertEquals(false, $this->dateValidator->validate("35-01-2012"));
        $this->assertEquals(false, $this->dateValidator->validate("01-14-2012"));
        $this->assertEquals(false, $this->dateValidator->validate("01-10-2050"));
        $this->assertEquals(false, $this->dateValidator->validate("01-10-1800"));
        $this->assertEquals(false, $this->dateValidator->validate("2020-01-02"));
        $this->assertEquals(false, $this->dateValidator->validate("4h35jkh4h"));
        $this->assertEquals(false, $this->dateValidator->validate("10-01-0001"));
        $this->assertEquals(false, $this->dateValidator->validate("10-01-1920"));
        $this->assertEquals(false, $this->dateValidator->validate("10-06-2030"));
        $this->assertEquals(false, $this->dateValidator->validate("10-14-2000"));
        $this->assertEquals(false, $this->dateValidator->validate("10-10-200"));
        $this->assertEquals(false, $this->dateValidator->validate("10-10-19999"));
        $this->assertEquals(false, $this->dateValidator->validate(""));
        $this->assertEquals(true, $this->dateValidator->validate("1-5-2019"));
    }

    public function tearDown() {
        echo "\n" . $this->dateValidator->getError() . "\n";
    }
}
?>
