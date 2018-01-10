<?php
/**
 * User: smart
 * Date: 25-12-2017
 * Time: 2:23 CH
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ResetButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label'      => __('Reset'),
            'class'      => 'reset',
            'on_click'   => 'location.reload();',
            'sort_order' => 30
        ];
    }
}