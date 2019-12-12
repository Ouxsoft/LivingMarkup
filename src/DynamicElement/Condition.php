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

        // complete any missing info from end date
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

        // complete any missing info from end date
        foreach ($end as $key => $value) {
            if (!empty($start[$key])) {
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
