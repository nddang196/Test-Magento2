<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 4:09 CH
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Framework\Exception\LocalizedException;
use MyModule\Label\Model\Label;
use MyModule\Label\Model\ProductLabelFactory;

class Save extends Action
{
    /**
     * @var Label
     */
    protected $_labelModel;
    /**
     * @var
     */
    protected $_prdLabel;
    /**
     * @var Js
     */
    protected $_jsHelper;

    /**
     * Save constructor.
     *
     * @param Context             $context
     * @param Label               $label
     * @param ProductLabelFactory $prdLabelFactory
     * @param Js                  $jsHelper
     */
    public function __construct(Context $context, Label $label, ProductLabelFactory $prdLabelFactory, Js $jsHelper)
    {
        $this->_labelModel = $label;
        $this->_jsHelper = $jsHelper;
        $this->_prdLabel = $prdLabelFactory->create();
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
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $this->_labelModel->load($id);
            } else {
                unset($data['id']);
                $data['created_at'] = time();
            }
            $data['updated_at'] = time();
            $this->_labelModel->setData($data);

            $this->_eventManager->dispatch(
                'label_prepare_save',
                ['label' => $this->_labelModel, 'request' => $this->getRequest()]
            );

            try {
                $this->_labelModel->save();
                $this->saveProducts($this->_labelModel->getId(), $data);
                $this->messageManager->addSuccess(__('Save success!'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $this->_labelModel->getId(), '_current' => true]);
                }

                return $resultRedirect->setPath('*/*/grid');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving!'));
            }

            $this->_getSession()->setFormData($data);

            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        return $resultRedirect->setPath('*/*/grid');
    }

    public function saveProducts($labelId, $postData)
    {
        if (!empty($postData['products'])) {
            $productIds = $this->_jsHelper->decodeGridSerializedInput($postData['products']);
            $prdLabelCollection = $this->_prdLabel->getCollection()->addFieldToFilter('lid', $labelId);
            
            try {
                $prdLabelCollection->walk('delete');
                foreach ($productIds as $productId) {
                    $this->_prdLabel->setData(['lid' => $labelId, 'pid' => $productId]);
                    $this->_prdLabel->save();
                }
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving product label.'));
            }
        }
    }

    public function validate($data)
    {

    }
}