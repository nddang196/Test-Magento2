<?php
/**
 * User: smart
 * Date: 25-12-2017
 * Time: 2:24 CH
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton  implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'          => __('Save'),
            'class'          => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order'     => 90,
        ];
    }
}