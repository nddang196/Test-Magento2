<?php
/**
 * User: vothanhphong
 * Date: 12/24/17
 * Time: 2:31 PM
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit;


class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('label_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Label Information'));
    }
}