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

namespace Mageplaza\QuickFlushCache\Plugin\Model\ResourceModel\System\Message\Collection;

use Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\Synchronized as MessageSynchronized;
use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Mageplaza\QuickFlushCache\Helper\Data as HelperData;
use Mageplaza\QuickFlushCache\Model\Config\Source\System\YesNo;

/**
 * Class Synchronized
 * @package Mageplaza\QuickFlushCache\Plugin\Model\ResourceModel\System\Message\Collection
 */
class Synchronized
{
    /**
     * @var ManagerInterface
     */
    protected $_eventManager;

    /**
     * @var MessageManagerInterface
     */
    protected $_messageManager;

    /**
     * @var TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * Synchronized constructor.
     *
     * @param ManagerInterface $eventManager
     * @param MessageManagerInterface $messageManager
     * @param TypeListInterface $cacheTypeList
     * @param HelperData $helperData
     */
    public function __construct(
        ManagerInterface $eventManager,
        MessageManagerInterface $messageManager,
        TypeListInterface $cacheTypeList,
        HelperData $helperData
    ) {
        $this->_eventManager   = $eventManager;
        $this->_messageManager = $messageManager;
        $this->_cacheTypeList  = $cacheTypeList;
        $this->_helperData     = $helperData;
    }

    /**
     * @param MessageSynchronized $subject
     * @SuppressWarnings(Unused)
     */
    public function before_afterLoad(MessageSynchronized $subject)
    {
        if ($this->_helperData->isEnabledFlushCache() === YesNo::AUTO) {
            $invalidCaches = [];
            foreach ($this->_cacheTypeList->getInvalidated() as $type) {
                $invalidCaches[] = $type->getId();
            }
            if ($invalidCaches) {
                foreach ($invalidCaches as $typeId) {
                    $this->_cacheTypeList->cleanType($typeId);
                }
                $this->_eventManager->dispatch('adminhtml_cache_flush_system');
            }
        }
    }
}
