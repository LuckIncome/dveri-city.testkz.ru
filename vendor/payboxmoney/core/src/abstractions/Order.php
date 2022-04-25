<?php

/*
 * This file is part of the Core package in (c)Paybox Integration Component.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace Paybox\Core\Abstractions;

/**
 *
 * @package Paybox\Core\Abstractions
 * @version 1.2.2
 * @author Sergey Astapenko <sa@paybox.money> @link https://paybox.money
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 */

abstract class Order extends DataContainer {

    /**
     * @var string $id Identifier of order in Your database
     */
    public $id;

    /**
     * @var int $amount Total amount of order
     */
    public $amount;

    /**
     * @var string $description Description of order
     */
    public $description;

}
