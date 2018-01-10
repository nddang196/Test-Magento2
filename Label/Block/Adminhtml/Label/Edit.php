<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 3:56 CH
 */

namespace MyModule\Label\Block\Adminhtml\Label;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param Context  $context
     * @param Registry $registry
     * @param array    $data
     */
    public function __construct(Context $context, Registry $registry, array $data = [])
    {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize blog post edit block
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'MyModule_Label';
        $this->_controller = 'adminhtml_label';

        parent::_construct();

        if ($this->_isAllowedAction('MyModule_Label::save')) {
            $this->buttonList->update('save', 'label', __('Save'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label'          => __('Save and Continue Edit'),
                    'class'          => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ]
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('MyModule_Label::delete')) {
            $this->buttonList->update('delete', 'label', __('Delete'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    public function getBackUrl()
    {
        return $this->getUrl('*/*/grid');
    }

    /**
     * Retrieve text for header element depending on loaded post
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->_coreRegistry->registry('label_model')->getId()) {
            return __("Edit Label of Product '%1'", $this->escapeHtml($this->_coreRegistry->registry('label_model')->getTitle()));
        } else {
            return __('New Label');
        }
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }
}