<?php
/**
 * User: vothanhphong
 * Date: 12/24/17
 * Time: 2:34 PM
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use MyModule\Label\Helper\Data;
use MyModule\Label\Model\LabelPosition;

class Main extends Generic implements TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $store;

    /**
     * @var Data
     */
    protected $helper;

    protected $_labelPosition;

    /**
     * Main constructor.
     *
     * @param Context       $context
     * @param Registry      $registry
     * @param LabelPosition $labelPosition
     * @param FormFactory   $formFactory
     * @param Data          $helper
     * @param array         $data
     */
    public function __construct(Context $context, Registry $registry, LabelPosition $labelPosition,
                                FormFactory $formFactory, Data $helper, array $data = [])
    {
        $this->helper         = $helper;
        $this->_labelPosition = $labelPosition;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        /* @var $model \MyModule\Label\Model\Label */
        $model = $this->_coreRegistry->registry('label_model');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('label_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField(
            'code',
            'text',
            [
                'name'     => 'code',
                'label'    => __('Code'),
                'title'    => __('Code'),
                'required' => true,
            ]
        );
        $fieldset->addField(
            'title',
            'text',
            [
                'name'     => 'title',
                'label'    => __('Title'),
                'title'    => __('Title'),
                'required' => true,
            ]
        );

        $fieldset->addField(
            'position',
            'select',
            [
                'name'     => 'position',
                'label'    => __('Position'),
                'title'    => __('Position'),
                'required' => true,
                'values'   => $this->_labelPosition->toOptionArray(),
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name'     => 'is_active',
                'label'    => __('Enabel'),
                'title'    => __('Enabel'),
                'required' => true,
                'options'  => ['1' => __('Yes'), '0' => __('No')],
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Main');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Main');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}