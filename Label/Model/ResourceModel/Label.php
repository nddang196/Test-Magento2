<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 10:03 SA
 */

namespace MyModule\Label\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Label extends AbstractDb
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('mymodule_label', 'id');
    }

    /**
     * Process post data before saving
     *
     * @param AbstractModel $object
     *
     * @return $this
     */
//    protected function _beforeSave(AbstractModel $object)
//    {
//        if ($object->isObjectNew() && !$object->hasCreationTime()) {
//            $object->setCreationTime($this->_date->gmtDate());
//        }
//
//        $object->setUpdateTime($this->_date->gmtDate());
//
//        return parent::_beforeSave($object);
//    }
}