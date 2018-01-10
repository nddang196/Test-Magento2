<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 10:06 SA
 */

namespace MyModule\Label\Model\ResourceModel\Label;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    protected $_eventPrefix = 'mymodule_label_label_collection';
    protected $_eventObject = 'label_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MyModule\Label\Model\Label', 'MyModule\Label\Model\ResourceModel\Label');
    }

}