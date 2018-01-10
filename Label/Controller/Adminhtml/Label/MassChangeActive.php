<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 04/01/2018
 * Time: 09:23
 */

namespace MyModule\Label\Controller\Adminhtml\Label;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use MyModule\Label\Model\ResourceModel\Label\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

class MassChangeActive extends Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;


    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            if($item->getIsActive() == true) {
                $item->setIsActive(false);
            } else {
                $item->setIsActive(true);
            }
            $item->setUpdatedAt(time());

            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been changed status.', $collection->getSize()));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/grid');
    }
}