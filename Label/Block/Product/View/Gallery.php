<?php
/**
 * User: vothanhphong
 * Date: 01/01/2018
 * Time: 22:11
 */

namespace MyModule\Label\Block\Product\View;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\View\Gallery as MageGallery;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use MyModule\Label\Model\Label;

class Gallery extends MageGallery
{
    protected $_label;

    public function __construct(Context $context, ArrayUtils $arrayUtils, EncoderInterface $jsonEncoder,
                                array $data = [], Label $label)
    {
        parent::__construct($context, $arrayUtils, $jsonEncoder, $data);
        $this->_label = $label;
    }

    /**
     * @return string
     */
    public function getProductLabel()
    {
        $product    = $this->getProduct();
        $collection = $this->_label->getCollection();

        if ($product->getTypeId() == 'configurable') {
            return $this->configurableLabel($collection, $product);
        }

        $collection->getSelect()
            ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', [])
            ->where("lp.pid={$product->getId()}")
            ->where('main_table.is_active=1');

        return json_encode($collection->toArray()['items']);
    }

    /**
     * @param \MyModule\Label\Model\ResourceModel\Label\Collection $collection
     * @param                                                      $product
     * @return string
     */
    public function configurableLabel($collection, $product)
    {
        $simplePrd   = $product->getTypeInstance()->getUsedProducts($product);
        $simpleIds[] = $product->getId();

        foreach ($simplePrd as $item) {
            $simpleIds[] = $item->getId();
        }

        $collection->getSelect()
            ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', ['pid'])
            ->where('main_table.is_active=1')
            ->group('main_table.id');
        $collection->addFieldToFilter('pid', $simpleIds);

        return json_encode($collection->toArray()['items']);
    }

    public function getVar($name, $module = null)
    {
        if (empty($module)) {
            $module = 'Magento_Catalog';
        }
        return parent::getVar($name, $module); // TODO: Change the autogenerated stub
    }
}