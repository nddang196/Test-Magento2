<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 03/01/2018
 * Time: 10:49
 */

namespace MyModule\Label\Block\Product;

use Magento\Catalog\Block\Product\Image;
use Magento\Framework\View\Element\Template\Context;

class MyImage extends Image
{
    protected $_label;

    public function __construct(Context $context, array $data = [])
    {
        $this->_label = $data['product_label'];
        parent::__construct($context, $data);
    }

    public function getProductLabel()
    {
        return $this->_label;
    }
}