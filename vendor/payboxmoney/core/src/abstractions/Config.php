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
 * This class using for configure requests to Paybox
 *
 * @package Paybox\Core\Abstractions
 * @version 1.2.2
 * @author Sergey Astapenko <sa@paybox.money> @link https://paybox.money
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 */

abstract class Config extends DataContainer {

    /**
     * @var string $currency Set currency of order (ISO 4217)
     */

    public $currency;

    /**
     * @var string $paymentSystem select Payment System for order
     */

    public $paymentSystem;

    /**
     * @var string $encoding
     */

    public $encoding;

}
