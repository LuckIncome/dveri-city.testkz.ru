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
 * @copyright LLC Paybox.money
 * @license GPLv3 @link https://www.gnu.org/licenses/gpl-3.0-standalone.html
 *
 */

abstract class Card extends DataContainer {

    /**
     * @var string $id Identifier of card in Your database
     */
    public $id;

}
