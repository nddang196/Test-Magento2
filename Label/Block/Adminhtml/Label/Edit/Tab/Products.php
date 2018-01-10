<?php
/**
 * User: vothanhphong
 * Date: 12/24/17
 * Time: 2:34 PM
 */

namespace MyModule\Label\Block\Adminhtml\Label\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Registry;
use MyModule\Label\Model\LabelFactory;

class Products extends Extended
{
    /**
     * @var CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var LabelFactory
     */
    protected $_labelFactoty;
    /**
     * @var  Registry
     */
    protected $registry;

    /**
     *
     * @param Context           $context
     * @param Data              $backendHelper
     * @param Registry          $registry
     * @param LabelFactory      $labelFactory
     * @param CollectionFactory $productCollectionFactory
     * @param array             $data
     */
    public function __construct(Context $context, Data $backendHelper, Registry $registry, LabelFactory $labelFactory,
                                CollectionFactory $productCollectionFactory, array $data = [])
    {
        $this->_labelFactoty = $labelFactory;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->registry = $registry;

        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * _construct
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('id')) {
            $this->setDefaultFilter(array('in_product' => 1));
        }
    }

    /**
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_product') {
            $productIds = $this->_getSelectedProducts();

            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * prepare collection
     */
    protected function _prepareCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('sku');
        $collection->addAttributeToSelect('price');
        $collection->addAttributeToSelect('type_id');
        $collection->addAttributeToSelect('thumbnail');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Extended
     * @throws \Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_product',
            [
                'header_css_class' => 'a-center',
                'type'             => 'checkbox',
                'name'             => 'in_product',
                'align'            => 'center',
                'index'            => 'entity_id',
                'values'           => $this->_getSelectedProducts(),
            ]
        );

        $this->addColumn(
            'entity_id',
            [
                'header'           => __('Product ID'),
                'type'             => 'number',
                'index'            => 'entity_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'thumbnail',
            [
                'header' => __('Thumbnail'),
                'index'  => 'thumbnail',
                'renderer'  => '\MyModule\Label\Block\Adminhtml\Label\Helper\Image',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index'  => 'name',
            ]
        );
        $this->addColumn(
            'type_id',
            [
                'header' => __('Type'),
                'index'  => 'type_id',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('Sku'),
                'index'  => 'sku',
            ]
        );
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type'   => 'currency',
                'index'  => 'price',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productsgrid', ['_current' => true]);
    }

    /**
     * @param  object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return '';
    }

    /**
     * @return mixed
     */
    protected function _getSelectedProducts()
    {
        $labelId = $this->getRequest()->getParam('id');
        $label = $this->_labelFactoty->create();
        if ($labelId) {
            $label->load($labelId);
        }

        return $label->getProducts($label);
    }

    /**
     * Retrieve selected products
     *
     * @return array
     */
    public function getSelectedProducts()
    {
        $selected = $this->_getSelectedProducts();

        if (!is_array($selected)) {
            $selected = [];
        }

        return $selected;
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
        return true;
    }
}