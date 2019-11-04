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

namespace Mageplaza\QuickFlushCache\Plugin\Controller\Cache;

use Magento\Backend\Controller\Adminhtml\Cache\Index as CacheIndex;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\ViewInterface;
use Mageplaza\QuickFlushCache\Helper\Data as HelperData;
use Mageplaza\QuickFlushCache\Model\Config\Source\System\YesNo;

/**
 * Class Index
 * @package Mageplaza\QuickFlushCache\Plugin\Controller\Cache
 */
class Index
{
    /**
     * @var ViewInterface
     */
    protected $_view;

    /**
     * @var ResponseInterface
     */
    protected $_response;

    /**
     * @var HelperData
     */
    protected $_helperData;

    /**
     * Invalid constructor.
     *
     * @param ViewInterface $view
     * @param ResponseInterface $response
     * @param HelperData $helperData
     */
    public function __construct(
        ViewInterface $view,
        ResponseInterface $response,
        HelperData $helperData
    ) {
        $this->_view       = $view;
        $this->_response   = $response;
        $this->_helperData = $helperData;
    }

    /**
     * @param CacheIndex $subject
     * @param $result
     * @SuppressWarnings(Unused)
     *
     * @return mixed
     */
    public function afterExecute(CacheIndex $subject, $result)
    {
        if ($this->_helperData->isEnabledFlushCache() === YesNo::MANUAL && $subject->getRequest()->isAjax()) {
            $gridBlock = $this->_view->getLayout()->getBlock('adminhtml.cache.container');

            return $this->_response->representJson($gridBlock->toHtml());
        }

        return $result;
    }
}
