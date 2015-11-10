# YiiDateValidator Extension #

Yii extension to validate dates and date ranges

**Usage**

Copy the YiiDateValidator folder to your extension folder inside your protected folder.

Then just use it as a validation rule inside your Model:
```php
public function rules() {
    return array(
        ...
        array('start_date', 'application.extensions.YDateValidator.YDateValidator', 'format' => 'm-Y', 'rangeMin' => '01-1950', 'rangeMax' => date('m-Y', strtotime('01-01-' . (date('Y') + 5))), 'regex' => '/^\d{1,2}-\d{4}$/', 'allowEmpty' => true, 'convertToFormat' => 'Y-m-d', 'invalidFormatMsg' => 'The date format must be mm-yyyy.'),
        ...
    );
}
```
**Validator parameters:**
- format (format the dates are asked to the users)
- rangeMin (min date validation)
- rangeMax (max date validation)
- regex (regex validator for the format)
- allowEmpty (if this date can be null or not)
- convertFormat (format to convert the date after it gets validated)

**More info on using Yii Extensions**
http://www.yiiframework.com/doc/guide/1.1/en/extension.use

**About the author**
   - Email: joaopedrocr@gmail.com
   - Blog: http://joaoperibeiro.com
   - Personal Page: http://joaopcribeiro.branded.me
