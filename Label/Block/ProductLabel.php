<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 09/01/2018
 * Time: 10:18
 */

namespace MyModule\Label\Block;

use Magento\Framework\View\Element\Template;

/**
 * Class ProductLabel
 * @package MyModule\Label\Block
 */
class ProductLabel extends Template
{
    /**
     * ProductLabel constructor.
     * @param Template\Context $context
     * @param array            $data
     */
    public function __construct(Template\Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }

}