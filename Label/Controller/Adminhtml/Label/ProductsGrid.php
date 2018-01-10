<?php
/**
 * User: vothanhphong
 * Date: 05/01/2018
 * Time: 22:39
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\LayoutFactory;

class ProductsGrid extends Action
{

    /**
     * @var LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param LayoutFactory $resultLayoutFactory
     * @param Context       $context
     */
    public function __construct(Context $context, LayoutFactory $resultLayoutFactory)
    {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('mylabel.edit.tab.products')
            ->setInProducts($this->getRequest()->getPost('label_products', null));

        return $resultLayout;
    }
}