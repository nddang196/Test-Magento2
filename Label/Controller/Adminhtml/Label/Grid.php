<?php
/**
 * User: vothanhphong
 * Date: 12/22/17
 * Time: 9:49 AM
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;

class Grid extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;
    protected $_resultPage;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $this->_setPageData();
        return $this->getResultPage();
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MyModule_Label::label');
    }

    public function getResultPage()
    {
        if (is_null($this->_resultPage)) {
            $this->_resultPage = $this->_resultPageFactory->create();
        }

        return $this->_resultPage;
    }

    protected function _setPageData()
    {
        $resultPage = $this->getResultPage();
        $resultPage->setActiveMenu('MyModule_Label::label');
        $resultPage->getConfig()->getTitle()->prepend((__('Product Label')));

        $resultPage->addBreadcrumb(__('MyModule'), __('My Moduel'));
        $resultPage->addBreadcrumb(__('Label'), __('Product Label'));

        return $this;
    }
}