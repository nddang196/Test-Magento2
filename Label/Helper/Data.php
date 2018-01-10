<?php
/**
 * User: vothanhphong
 * Date: 12/24/17
 * Time: 2:51 PM
 */

namespace MyModule\Label\Helper;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{

    /**
     * @var UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * Data constructor.
     * @param Context               $context
     * @param UrlInterface          $backendUrl
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(Context $context, UrlInterface $backendUrl, StoreManagerInterface $storeManager)
    {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
    }

    /**
     * get products tab Url in admin
     * @return string
     */
    public function getProductsGridUrl()
    {
        return $this->_backendUrl->getUrl('mylabel/label/products', ['_current' => true]);;
    }
}