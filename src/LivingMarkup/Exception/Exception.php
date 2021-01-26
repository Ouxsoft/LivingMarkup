<?php
/**
 * This file is part of the LivingMarkup package.
 *
 * (c) 2017-2020 Ouxsoft  <contact@ouxsoft.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace LivingMarkup\Exception;

use RuntimeException;

/**
 * Class Exception
 *
 * @package LivingMarkup
 */
class Exception extends RuntimeException
{
    private $log = null;

    /**
     * Exception constructor.
     *
     * @param $log
     */
    public function __construct($log = null)
    {
        parent::__construct();

        $this->log = $log;
    }

    /**
     * Returns log
     * @return string|null
     */
    public function getLog(): ?string
    {
        return $this->log;
    }
}
