<?php
/**
 * User: vothanhphong
 * Date: 12/22/17
 * Time: 10:03 AM
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;

class NewAction extends Action
{
    /**
     * @var \Magento\Backend\Model\View\Result\Forward
     */
    protected $resultForwardFactory;

    /**
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(Context $context, ForwardFactory $resultForwardFactory)
    {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MyModule_Label::save');
    }

    /**
     * Forward to edit
     *
     * @return \Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}