<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 4:01 CH
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    /**
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            ['data' => ['id' => 'edit_form', 'action' => $this->getData('action'), 'method' => 'post']]
        );
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}