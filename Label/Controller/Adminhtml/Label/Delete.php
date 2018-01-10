<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 2:20 CH
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use MyModule\Label\Model\Label;

class Delete extends Action
{
    protected $_model;

    /**
     * Delete constructor.
     * @param Context $context
     * @param Label   $model
     */
    public function __construct(Context $context, Label $model)
    {
        parent::__construct($context);
        $this->_model = $model;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MyModule_Label::label');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_model;
                $model->setId($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Label deleted'));
                return $resultRedirect->setPath('*/*/grid');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('Label does not exist'));

        return $resultRedirect->setPath('*/*/grid');
    }
}