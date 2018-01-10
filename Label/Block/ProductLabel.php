<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 09/01/2018
 * Time: 10:18
 */

namespace MyModule\Label\Block;

use Magento\Framework\View\Element\Template;

class ProductLabel extends Template
{
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

}