<?php
/**
 * User: smart
 * Date: 25-12-2017
 * Time: 2:24 CH
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];

        if ($this->getId()) {
            $data = [
                'label'          => __('Save and Continue Edit'),
                'class'          => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button'    => ['event' => 'saveAndContinueEdit'],
                    ],
                ],
                'sort_order'     => 80,
            ];
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', ['back' => 1]);
    }
}