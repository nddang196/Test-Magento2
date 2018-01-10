<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 03/01/2018
 * Time: 09:57
 */

namespace MyModule\Label\Block\Product;

use Magento\Catalog\Model\Product;
use MyModule\Label\Model\Label;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Block\Product\ImageFactory;
use Magento\Catalog\Helper\ImageFactory as HelperFactory;

class MyImageBuilder extends ImageBuilder
{
    /**
     * @var Label
     */
    protected $_label;

    /**
     * MyImageBuilder constructor.
     * @param HelperFactory $helperFactory
     * @param ImageFactory  $imageFactory
     * @param Label         $label
     * @param Product       $product
     */
    public function __construct(HelperFactory $helperFactory, ImageFactory $imageFactory, Label $label, Product $product)
    {
        $this->_label  = $label;
        $this->product = $product;
        parent::__construct($helperFactory, $imageFactory);
    }

    public function create()
    {
        /** @var \Magento\Catalog\Helper\Image $helper */
        $helper = $this->helperFactory->create()
            ->init($this->product, $this->imageId);

        $template = $helper->getFrame()
            ? 'Magento_Catalog::product/image.phtml'
            : 'MyModule_Label::product/image_with_borders.phtml';

        $imagesize = $helper->getResizedImageInfo();

        $data = [
            'data' => [
                'template'             => $template,
                'image_url'            => $helper->getUrl(),
                'width'                => $helper->getWidth(),
                'height'               => $helper->getHeight(),
                'label'                => $helper->getLabel(),
                'ratio'                => $this->getRatio($helper),
                'custom_attributes'    => $this->getCustomAttributes(),
                'resized_image_width'  => !empty($imagesize[0]) ? $imagesize[0] : $helper->getWidth(),
                'resized_image_height' => !empty($imagesize[1]) ? $imagesize[1] : $helper->getHeight(),
                'product_label'        => $this->getLabel(),
            ],
        ];

        return $this->imageFactory->create($data);
    }

    /**
     * @return array
     */
    public function getLabel()
    {
        $productId   = $this->product->getId();
        $productType = $this->product->getTypeId();
        $collection  = $this->_label->getCollection();

        if ($productType == 'configurable') {
            return $this->configurableLabel($collection);
        }

        $collection->getSelect()
            ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', [])
            ->where("lp.pid=$productId")
            ->where('main_table.is_active=1');

        return $collection->toArray()['items'];
    }

    /**
     * @param \MyModule\Label\Model\ResourceModel\Label\Collection $collection
     *
     * @return array
     */
    public function configurableLabel($collection)
    {
        $simplePrd = $this->product->getTypeInstance()->getUsedProducts($this->product);
        $simpleIds[] = $this->product->getId();

        foreach ($simplePrd as $item) {
            $simpleIds[] = $item->getId();
        }

        $collection->getSelect()
            ->join(['lp' => 'mymodule_product_label'], 'main_table.id = lp.lid', ['pid'])
            ->where('main_table.is_active=1')
            ->group('main_table.id');
        $collection->addFieldToFilter('pid', $simpleIds);

//        die(var_dump($collection->toArray()['items']));
        return $collection->toArray()['items'];
    }
}