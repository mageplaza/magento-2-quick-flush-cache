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

namespace Mageplaza\QuickFlushCache\Helper;

use Exception;
use Magento\AdminNotification\Model\ResourceModel\System\Message as SystemMessageResource;
use Magento\AdminNotification\Model\ResourceModel\System\Message\Collection\SynchronizedFactory as SynchronizedColFact;
use Magento\AdminNotification\Model\System\Message as SystemMessageModel;
use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Notification\MessageList;
use Magento\Framework\ObjectManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Mageplaza\Core\Helper\AbstractData;

/**
 * Class Data
 * @package Mageplaza\QuickFlushCache\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mpquickflushcache';

    /**
     * @var FormKey
     */
    protected $_formKey;

    /**
     * @var UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var MessageList
     */
    protected $_messageList;

    /**
     * @var SystemMessageResource
     */
    protected $_messageResource;

    /**
     * @var SynchronizedColFact
     */
    protected $_synchronizedColFact;

    /**
     * Data constructor.
     *
     * @param Context $context
     * @param ObjectManagerInterface $objectManager
     * @param StoreManagerInterface $storeManager
     * @param FormKey $formKey
     * @param UrlInterface $backendUrl
     * @param MessageList $messageList
     * @param SystemMessageResource $messageResource
     * @param SynchronizedColFact $synchronizedColFact
     */
    public function __construct(
        Context $context,
        ObjectManagerInterface $objectManager,
        StoreManagerInterface $storeManager,
        FormKey $formKey,
        UrlInterface $backendUrl,
        MessageList $messageList,
        SystemMessageResource $messageResource,
        SynchronizedColFact $synchronizedColFact
    ) {
        parent::__construct(
            $context,
            $objectManager,
            $storeManager
        );

        $this->_formKey             = $formKey;
        $this->_backendUrl          = $backendUrl;
        $this->_messageList         = $messageList;
        $this->_messageResource     = $messageResource;
        $this->_synchronizedColFact = $synchronizedColFact;
    }

    /**
     * @return bool
     */
    public function isEnabledFlushCache()
    {
        return $this->getConfigGeneral('enabled_flush_cache');
    }

    /**
     * @return bool
     */
    public function isEnabledReindex()
    {
        return $this->getConfigGeneral('enabled_reindex');
    }

    /**
     * @throws Exception
     */
    public function synchronizedSystemMessage()
    {
        $messages  = $this->_messageList->asArray();
        $persisted = [];
        $items     = $this->_synchronizedColFact->create()->getItems();
        foreach ($messages as $message) {
            if ($message->isDisplayed()) {
                foreach ($items as $persistedKey => $persistedMessage) {
                    if ($message->getIdentity() === $persistedMessage->getIdentity()) {
                        $persisted[$persistedKey] = $persistedMessage;
                        continue 2;
                    }
                }
            }
        }
        $removed = array_diff_key($items, $persisted);
        foreach ($removed as $removedItem) {
            /** @var SystemMessageModel $removedItem */
            $this->_messageResource->delete($removedItem);
        }
    }

    /**
     * @return string
     */
    public function getFlushCacheUrl()
    {
        return $this->_backendUrl->getUrl('mpquickflushcache/cache/flushSystem', [
            'form_key' => $this->_formKey->getFormKey()
        ]);
    }

    /**
     * @return string
     */
    public function getReindexUrl()
    {
        return $this->_backendUrl->getUrl('mpquickflushcache/indexer/reindex', [
            'form_key' => $this->_formKey->getFormKey()
        ]);
    }
}
