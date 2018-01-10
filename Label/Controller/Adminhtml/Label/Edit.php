<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 3:43 CH
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use MyModule\Label\Model\Label;

class Edit extends Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var Label
     */
    protected $_label;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     * @param Registry    $registry
     * @param Label       $label
     */
    public function __construct(Context $context, PageFactory $resultPageFactory, Registry $registry, Label $label)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->_label = $label;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MyModule_Label::label');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('MyModule_Label::label')
            ->addBreadcrumb(__('MyModule'), __('My Module'))
            ->addBreadcrumb(__('Product Label'), __('Product Label'));

        return $resultPage;
    }

    /**
     * Edit Blog post
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if ($id) {
            $this->_label->load($id);
            if (!$this->_label->getId()) {
                $this->messageManager->addError(__('This label no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/grid');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $this->_label->setData($data);
        }

        $this->_coreRegistry->register('label_model', $this->_label);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Label') : __('Create Label'),
            $id ? __('Edit Label') : __('Create Label')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Product Label Manage'));
        $resultPage->getConfig()->getTitle()
            ->prepend($this->_label->getId() ? __('Edit Label') : __('Create Label'));

        return $resultPage;
    }
}