<?php
/**
 * This file is part of the PXP package.
 *
 * (c) Matthew Heroux <matthewheroux@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pxp\DynamicElement;

/**
 * Class Condition
 *
 * Used to determine whether innerHTML is omitted from rendered output
 *
 * <condition toggle="signed_in">
 * <p>Welcome Member</p>
 * </condition>
 */
class Condition extends DynamicElement
{

    private $days_of_week = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    /**
     * Check if now is between start and end time
     *
     * @param string $time_start
     * @param string $time_end
     * @return bool
     * @throws \Exception
     */
    public function isTimeNowBetween(string $time_start, string $time_end)
    {

        // start
        $start = date_parse($time_start);
        $start_datetime = new \DateTime();
        $start_datetime->setTime($start['hour'], $start['minute'], $start['second']);

        // now
        $now_datetime = new \DateTime('NOW');

        // end
        $end = date_parse($time_end);
        $end_datetime = new \DateTime();
        $end_datetime->setTime($end['hour'], $end['minute'], $end['second']);

        // use next day if end time before start time
        if($start_datetime->getTimestamp() > $end_datetime->getTimestamp() ){
            $end_datetime->modify('+ 1 day');
        }

        // if now between start and end return true
        if (($now_datetime->getTimestamp() > $start_datetime->getTimestamp()) &&
            ($now_datetime->getTimestamp() < $end_datetime->getTimestamp())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if date is between start and end date
     *
     * @param string $date_start
     * @param string $date_end
     * @return bool
     * @throws \Exception
     */
    public function isDateNowBetween(string $date_start, string $date_end)
    {

        // start
        $start = date_parse($date_start);
        $start_datetime = new \DateTime();
        $start_datetime->setDate($start['year'], $start['month'], $start['day']);
        $start_datetime->setTime(0, 0, 0);

        // now
        $now_datetime = new \DateTime('NOW');

        // end
        $end = date_parse($date_end);
        $end_datetime = new \DateTime();
        $end_datetime->setDate($end['year'], $end['month'], $end['day']);
        $end_datetime->setTime(23, 59, 59);

        // use next day if end time before start time
        if($start_datetime->getTimestamp() > $end_datetime->getTimestamp() ){
            $end_datetime->modify('+ 1 day');
        }

        // if now between start and end return true
        if (($now_datetime->getTimestamp() > $start_datetime->getTimestamp()) &&
            ($now_datetime->getTimestamp() < $end_datetime->getTimestamp())) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Checks if NOW is the same day of week
     *
     * @param $day_of_week
     * @return bool
     */
    public function isNowSameDayOfWeek($day_of_week) {
        $now_day_of_week = date('l', strtotime('NOW'));

        // check for multiple days of week if provided
        if(is_array($day_of_week)){
            foreach($day_of_week as $key => $value){
                if($now_day_of_week ==  date('l', strtotime($value)) ) {
                    return true;
                }

            }
        // check for one day of week if provided
        } else if (is_string($day_of_week) && ($now_day_of_week == date('l', strtotime($value) ) ) ) {
            return true;
        }

        return false;
    }

    /**
     * Checks if NOW is between to start and end datetime
     *
     * @param string $date_start
     * @param string $date_end
     * @return bool
     * @throws \Exception
     */
    public function isDatetimeNowBetween(string $date_start, string $date_end)
    {
        // TODO FIX STILL BUGGY

        // now
        $now_datetime = new \DateTime('NOW');

        // parse start date
        $start = date_parse($date_start);

        // complete any missing info from start date
        foreach ($start as $key => $value) {
            if (!empty($start[$key])) {
                continue;
            }

            // set defaults
            switch ($key) {
                // first hour, minute, second possible
                case 'hour':
                case 'minute':
                case 'second':
                    $start[$key] = '0';
                    break;
                // this month
                case 'month':
                    $start[$key] = date('n');
                    break;
                // first day of month
                case 'day':
                    $start[$key] = 1;
                    break;
                // this year
                case 'year':
                    $start[$key] = date('Y');
                    break;
                default:
                    continue;
            }
        }

        $start_datetime = new \DateTime();
        $start_datetime->setDate($start['year'], $start['month'], $start['day']);
        $start_datetime->setTime($start['hour'], $start['minute'], $start['second']);

        // parse end date
        $end = date_parse($date_end);

        // figure out if time set
        if( is_numeric($end['hour']) && is_numeric($end['minute']) && is_numeric($end['second']) ) {
            $end['time_set'] = true;
        } else {
            $end['time_set'] = false;
        }

        // figure out date set
        if( is_numeric($end['year']) && is_numeric($end['month']) && is_numeric($end['day']) ) {
            $end['date_set'] = true;
        } else {
            $end['date_set'] = false;
        }

        // set date to today if date not set but time is
        if( ($end['date_set'] == false) && ($end['time_set'] == true) ) {
            $end['month'] = date('n');
            $end['day'] = date('d');
            $end['year'] = date('Y');
        // set time to end of day if date set but time is not
        } else if( ($end['date_set'] == true) && ($end['time_set'] == false) ){
            $end['hour'] = '23';
            $end['minute'] = '59';
            $end['second'] = '59';
        // complete any missing info from end date
        } else {
            foreach ($end as $key => $value) {
                if ( is_numeric($end[$key])) {
                    continue;
                }

                // set defaults
                switch ($key) {
                    // last hour possible
                    case 'hour':
                        $end[$key] = '23';
                        break;
                    // last minute or second possible
                    case 'minute':
                    case 'second':
                        $end[$key] = '59';
                        break;
                    // this month
                    case 'month':
                        $end[$key] = date('n');
                        break;
                    // last day of month
                    case 'day':
                        $end[$key] = date('t');
                        break;
                    // this year
                    case 'year':
                        $end[$key] = date('Y');
                        break;
                }
            }
        }


        print_r($end);

        $end_datetime = new \DateTime();
        $end_datetime->setDate($end['year'], $end['month'], $end['day']);
        $end_datetime->setTime($end['hour'], $end['minute'], $end['second']);

        if (($now_datetime->getTimestamp() > $start_datetime->getTimestamp()) &&
            ($now_datetime->getTimestamp() < $end_datetime->getTimestamp())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Renders output if condition toggle is true
     *
     * @return string
     * @throws \Exception
     */
    public function onRender(): string
    {
        /*
         * This section contains conditional checks based on arguments
         * Ire passed the check is run if the check fails an empty string is returned.
         * This allows for different conditions to be added
         */

        // allow a condition based on time_start and time_end
        if ( isset($this->args['time_start']) && isset($this->args['time_end']) ) {
            if ( ! $this->isTimeNowBetween($this->args['time_start'], $this->args['time_end']) ) {
                return '';
            }
        }

        // allow a condition based on date_start and date_end
        if (isset($this->args['date_end']) && isset($this->args['date_start'])) {
            if ( ! $this->isDateNowBetween($this->args['date_start'], $this->args['date_end'])) {
                return '';
            }
        }

        // allow a condition based on day_of_week
        if (isset($this->args['day_of_week']) ) {
            if ( ! $this->isNowSameDayOfWeek($this->args['day_of_week'])) {
                return '';
            }
        }


        // if condition based on variable
        // <arg name="parent.limit" operator="equals">5</arg>
        // <arg name="this.limit" operator="GREATER_THAN">5</arg>
        // <arg name="child.limit" operator="LESS_THAN">5</arg>
        // <arg name="child.limit" operator="NOT_EQUAL">5</arg>
        // <arg name="child.limit" operator="CONTAINS">5</arg>

        // all conditions pass return xml
        return $this->xml;

    }
}