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

abstract class Merchant extends DataContainer {

    /**
     * @var int $id Uniq id of merchant in Paybox system
     */
    public $id;

    /**
     * @var string $secretKey Personal secret key of merchant in Paybox system
     */
    public $secretKey;

    public function __construct() {
        $this->required('id');
        $this->required('secretKey');
    }

}
