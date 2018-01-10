<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 02/01/2018
 * Time: 11:43
 */

namespace MyModule\Label\Block\Product;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Product as CatalogProduct;
use Magento\ConfigurableProduct\Helper\Data;
use Magento\ConfigurableProduct\Model\ConfigurableAttributeData;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Swatches\Block\Product\Renderer\Configurable as MagaConfiguarable;
use Magento\Swatches\Helper\Data as SwatchData;
use Magento\Swatches\Helper\Media;
use Magento\Swatches\Model\SwatchAttributesProvider;
use MyModule\Label\Model\Label;
use Magento\Catalog\Model\ProductFactory;

class Configurable extends MagaConfiguarable
{
    const MY_RENDERER_TEMPLATE = 'MyModule_Label::product/view/renderer.phtml';
    /**
     * @var Label
     */
    protected $_label;
    /**
     * @var ProductFactory
     */
    protected $_productFactory;

    public function __construct(Context $context, ArrayUtils $arrayUtils, EncoderInterface $jsonEncoder, Data $helper,
                                CatalogProduct $catalogProduct, CurrentCustomer $currentCustomer,
                                PriceCurrencyInterface $priceCurrency, ConfigurableAttributeData $configurableAttributeData,
                                SwatchData $swatchHelper, Media $swatchMediaHelper, array $data = [],
                                SwatchAttributesProvider $swatchAttributesProvider = null, Label $label, ProductFactory $productFactory)
    {
        $this->_label          = $label;
        $this->_productFactory = $productFactory;
        parent::__construct($context, $arrayUtils, $jsonEncoder, $helper, $catalogProduct, $currentCustomer,
            $priceCurrency, $configurableAttributeData, $swatchHelper, $swatchMediaHelper, $data,
            $swatchAttributesProvider);
    }

    /**
     * Return renderer template
     *
     * Template for product with swatches is different from product without swatches
     *
     * @return string
     */
    protected function getRendererTemplate()
    {
        return $this->isProductHasSwatchAttribute() ?
            self::MY_RENDERER_TEMPLATE : self::CONFIGURABLE_RENDERER_TEMPLATE;
    }

    /**
     * @return string
     */
    public function getConfigurableLabel()
    {
        $collection     = $this->_label->getCollection();
        $attributesData = $this->getSwatchAttributes();
        $product        = $this->getProduct();
        $simpleIds      = [];
        $simplePrd      = $product->getTypeInstance()->getUsedProducts($product);

        foreach ($simplePrd as $item) {
            $simpleIds[] = $item->getId();
        }

        $collection->getSelect()
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns(['title', 'position'])
            ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', ['pid'])
            ->where('main_table.is_active=1');
        $collection->addFieldToFilter('pid', $simpleIds);

        $label = $collection->toArray()['items'];

        foreach ($label as $key => $item) {
            $label[$key]['attr'] = $this->getSwatchAttributesProduct($item['pid'], $attributesData);
        }

        return $this->jsonEncoder->encode($label);
    }

//    public function getProductLabel()
//    {
//        $collection  = $this->_label->getCollection();
//        $product = $this->getProduct();
//
//        $simplePrd = $product->getTypeInstance()->getUsedProducts($this->product);
//        $simpleIds[] = $product->getId();
//
//        foreach ($simplePrd as $item) {
//            $simpleIds[] = $item->getId();
//        }
//
//        $collection->getSelect()
//            ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', ['pid'])
//            ->where('main_table.is_active=1')
//            ->group('main_table.id');
//        $collection->addFieldToFilter('pid', $simpleIds);
//
//        return $this->jsonEncoder->encode($collection->toArray()['items']);
//    }


    /**
     * @return array
     */
    public function getSwatchAttributes()
    {
        $attrData = $this->getSwatchAttributesData();
        $result   = [];

        foreach ($attrData as $item) {
            $result[] = $item['attribute_code'];
        }

        return $result;
    }

    /**
     * @param int   $productId
     * @param array $attributesData
     *
     * @return array
     */
    public function getSwatchAttributesProduct($productId, $attributesData)
    {
        $result  = [];
        $product = $this->_productFactory->create();
        $product->load($productId);

        foreach ($attributesData as $item) {
            $result[$item] = $product->getData($item);
        }

        return $result;
    }
}