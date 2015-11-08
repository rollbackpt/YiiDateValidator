<?php

require_once 'DateValidator/DateValidator.php';

use DateValidator\DateValidator;

class YiiDateValidator extends CValidator
{
    public $format = NULL;
    public $rangeMin = NULL;
    public $rangeMax = NULL;
    public $regex = NULL;
    public $allowEmpty = FALSE;
    public $convertToFormat = NULL;

    protected function validateAttribute($object, $attribute)
    {
        $date = $object->$attribute;

        if($this->allowEmpty && ($date === NULL || $date === '')) {
            return;
        }

        $date_zilla = new DateValidator($this->format, $this->rangeMin, $this->rangeMax, $this->regex);

        $result = $date_zilla->validate($date);

        if ($result === FALSE) {
            $message = $this->message !== NULL ? $this->message : $date_zilla->getError();
            $this->addError($object, $attribute, $message);
            return;
        }

        if ($this->format !== NULL && $this->convertToFormat !== NULL) {
            $object->$attribute = $this->convertFormat($date);
        }

        return;
    }

    private function convertFormat($date) {

        $date_parsed = date_parse_from_format($this->format, $date);
        if ($date_parsed['error_count'] > 0) {
            return $date;
        }
        if ($date_parsed['day'] === FALSE) {
            $date_parsed['day'] = '01';
        }
        if ($date_parsed['month'] === FALSE) {
            $date_parsed['month'] = '01';
        }

        return date($this->convertToFormat, strtotime($date_parsed['day'] . '-' . $date_parsed['month'] . '-' . $date_parsed['year']));
    }

}
