<?php
/**
 * User: smart
 * Date: 25-12-2017
 * Time: 2:23 CH
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton  implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getId()]);
    }
}