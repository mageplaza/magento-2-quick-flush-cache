<?php
/**
 * Mageplaza
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Mageplaza.com license that is
 * available through the world-wide-web at this URL:
 * https://www.mageplaza.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Mageplaza
 * @package     Mageplaza_QuickFlushCache
 * @copyright   Copyright (c) Mageplaza (https://www.mageplaza.com/)
 * @license     https://www.mageplaza.com/LICENSE.txt
 */

namespace Mageplaza\QuickFlushCache\Model\Config\Source\System;

use Mageplaza\QuickFlushCache\Model\Config\Source\AbstractOption;

/**
 * Class YesNo
 * @package Mageplaza\QuickFlushCache\Model\Config\Source\System
 */
class YesNo extends AbstractOption
{
    const AUTO   = '1';
    const MANUAL = '2';
    const NO     = '0';

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return [
            self::AUTO   => __('Yes (auto)'),
            self::MANUAL => __('Yes (manually)'),
            self::NO     => __('No'),
        ];
    }
}