<?php

namespace DateValidator;

/**
 * Date Validator Class
 *
 * @TODO: Added match_regex option, if the date also need to match a pattern
 */
class DateValidator {

    /**
     * Date Format (Default: None)
     */
    private $format;

    /**
     * Range Validation Min (Default: No min)
     */
    private $range_min;

    /**
     * Range Validation Max (Default: No max)
     */
    private $range_max;

    /**
     * Regex Pattern To Match (Default: None)
     */
    private $regex;

    /**
     * Error variable when validation fails
     */
    private $error;


    public function __construct($format = NULL, $range_min = NULL, $range_max = NULL, $regex = NULL) {
        $this->format = $format;
        $this->range_min = $range_min;
        $this->range_max = $range_max;
        $this->regex = $regex;
    }

    public function validate($date) {

        $this->setError("");

        if (strtotime($date) === FALSE && $this->format === NULL) {
            $this->error = 'The date is not valid';
            return FALSE;
        }

        if (!$this->validateRegex($date)) {
            return FALSE;
        }

        $date_parse = $this->validateFormat($date);

        if ($date_parse === FALSE) {
            return FALSE;
        }

        if (!$this->validateDate($date_parse)) {
            return FALSE;
        }

        if (!$this->validateRange($date)) {
            return FALSE;
        }

        return TRUE;
    }

    private function validateRegex($date) {
        if ($this->regex !== NULL) {
            if (preg_match($this->regex, $date) === FALSE) {
                $this->setError('The date format is invalid');
                return FALSE;
            }
        }

        return TRUE;
    }

    private function validateFormat($date) {

        if ($this->format === NULL) {
            $date_parse = date_parse($date);
            if ($date_parse['error_count'] > 0) {
                $this->error = 'The date format is invalid';
                return FALSE;
            } else {
                return $date_parse;
            }
        } else {
            $date_parse = date_parse_from_format($this->format, $date);
            if ($date_parse['error_count'] > 0) {
                $this->error = 'The date format is invalid';
                return FALSE;
            } else {
                return $date_parse;
            }
        }
    }

    private function validateDate($date) {
        if ($date['day'] === FALSE) {
            $date['day'] = '01';
        }
        if ($date['month'] === FALSE) {
            $date['month'] = '01';
        }

        if (checkdate($date['month'], $date['day'], $date['year'])) {
            return TRUE;
        } else {
            $this->error = 'The date is not valid';
            return FALSE;
        }
    }

    private function validateRange($date) {

        if ($this->format !== NULL) {
            $date = date_format(date_create_from_format($this->format, $date), 'Y-m-d');
            $date_min = date_format(date_create_from_format($this->format, $this->range_min), 'Y-m-d');
            $date_max = date_format(date_create_from_format($this->format, $this->range_max), 'Y-m-d');
        }

        if (!($this->range_min === NULL || (strtotime($date) >= strtotime($date_min)))) {
            $this->error = 'Date must be higher then ' . $this->range_min;
            return FALSE;
        }

        if (!($this->range_max === NULL || (strtotime($date) <= strtotime($date_max)))) {
            $this->error = 'Date must be lower then ' . $this->range_max;
            return FALSE;
        }

        return TRUE;
    }

    /**
     * Get last validation error
     */
    public function getError() {
        return $this->error;
    }

    /**
     * Get last validation error
     */
    public function setError($error) {
        $this->error = $error;
    }

}
?>
