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

    public function isTimeNowBetween(string $time_start, string $time_end)
    {
        // now
        $now_datetime = new \DateTime('NOW');

        // start
        $start = date_parse($time_start);
        $start_datetime = new \DateTime();
        $start_datetime->setTime($start['hour'], $start['minute'], $start['second']);

        // end
        $end = date_parse($time_end);
        $end_datetime = new \DateTime();
        $end_datetime->setTime($end['hour'], $end['minute'], $end['second']);

        // if now between start and end return true
        if (($now_datetime->getTimestamp() > $start_datetime->getTimestamp()) &&
            ($now_datetime->getTimestamp() < $end_datetime->getTimestamp())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if NOW is between to start and end date
     *
     * @param string $date_start
     * @param string $date_end
     * @return bool
     * @throws \Exception
     */
    public function isNowBetween(string $date_start, string $date_end)
    {

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
        $variable['signed_in'] = true;

        // if condition based on date_start and date_end
        if (isset($this->args['date_end']) && isset($this->args['date_start'])) {
            if ($this->isNowBetween($this->args['date_start'], $this->args['date_end'])) {
                return $this->xml;
            }
            return '';
        }

        // if condition based on time_start and time_end
        if (isset($this->args['time_end']) && isset($this->args['time_start'])) {
            if ($this->isTimeNowBetween($this->args['time_start'], $this->args['time_end'])) {
                return $this->xml;
            }
            return '';
        }

        // if no toggle set return empty
        if (!isset($this->args['toggle'])) {
            return '';
        }

        // get name of condition toggle variable
        $toggle_name = $this->args['@attributes']['toggle'];

        // check if variable set in processor
        if (!isset($variable[$toggle_name])) {
            return '';
        }

        // return inner content
        if ($variable[$toggle_name] == true) {
            return $this->xml;
        }

        return '';
    }
}
