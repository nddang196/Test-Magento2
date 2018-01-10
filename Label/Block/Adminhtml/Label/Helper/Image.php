<?php
/**
 * User: vothanhphong
 * Date: 06/01/2018
 * Time: 23:12
 */

namespace MyModule\Label\Block\Adminhtml\Label\Helper;

use Magento\Backend\Block\Context;
use Magento\Framework\DataObject;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

class Image extends AbstractRenderer
{
    private $_storeManager;

    /**
     * @param Context               $context
     * @param StoreManagerInterface $storemanager
     * @param array                 $data
     */
    public function __construct(Context $context, StoreManagerInterface $storemanager, array $data = [])
    {
        $this->_storeManager = $storemanager;
        parent::__construct($context, $data);
        $this->_authorization = $context->getAuthorization();
    }

    /**
     * Renders grid column
     *
     * @param DataObject $row
     *
     * @return  string
     */
    public function render(DataObject $row)
    {
        $mediaDirectory = $this->_storeManager->getStore()->getBaseUrl(
            \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
        );
        $imageUrl = $mediaDirectory.'/catalog/product'.$this->_getValue($row);
        return '<img src="'.$imageUrl.'" width="50"/>';
    }
}