<?php
/**
 * User: vothanhphong
 * Date: 12/22/17
 * Time: 3:44 PM
 */

namespace MyModule\Label\Model\ResourceModel;


use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class ProductLabel extends AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('mymodule_product_label', 'id');
    }
}