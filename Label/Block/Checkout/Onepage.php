<?php
/**
 * User: dangnd
 * Date: 11/01/2018
 * Time: 10:07
 */

namespace MyModule\Label\Block\Checkout;

use Magento\Catalog\Model\ProductFactory;
use Magento\Checkout\Model\CompositeConfigProvider;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template\Context;
use MyModule\Label\Model\LabelFactory;

class Onepage extends \Magento\Checkout\Block\Onepage
{
    /**
     * @var LabelFactory
     */
    private $__labelFactory;

    private $__productFactory;

    public function __construct(
            Context $context,
            FormKey $formKey,
            CompositeConfigProvider $configProvider,
            array $layoutProcessors = [],
            array $data = [],
            Json $serializer = null,
            LabelFactory $labelFactory,
            ProductFactory $productFactory
    ) {
        $this->__labelFactory   = $labelFactory;
        $this->__productFactory = $productFactory;
        parent::__construct($context, $formKey, $configProvider, $layoutProcessors, $data, $serializer);
    }

    public function getCheckoutConfig()
    {
        $config = parent::getCheckoutConfig();

        foreach ($config['quoteItemData'] as $item) {
            /** @var array $label */
            $label = $this->getProductLabel($item['sku']);
            if (!empty($label)) {
                $config['imageData'][$item['item_id']]['label'] = $label;
            }
        }

        return $config;
    }

    /**
     * Get product label by sku
     *
     * @param $skuProduct
     *
     * @return array
     */
    public function getProductLabel($skuProduct)
    {
        $label      = $this->__labelFactory->create();
        $product    = $this->__productFactory->create();
        $productId  = $product->loadByAttribute('sku', $skuProduct)->getId();
        $collection = $label->getCollection();

        $collection->getSelect()
                ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', [])
                ->where("lp.pid=$productId")
                ->where('main_table.is_active=1');

        return $collection->toArray()['items'];
    }
}