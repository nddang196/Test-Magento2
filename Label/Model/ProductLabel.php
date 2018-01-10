<?php
/**
 * User: vothanhphong
 * Date: 12/22/17
 * Time: 3:43 PM
 */

namespace MyModule\Label\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class ProductLabel extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'mymodule_productlabel';

    protected $_cacheTag = 'mymodule_productlabel';

    protected $_eventPrefix = 'mymodule_productlabel';

    protected function _construct()
    {
        $this->_init('MyModule\Label\Model\ResourceModel\ProductLabel');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function getProducts(\MyModule\Label\Model\ProductLabel $object)
    {
        $tbl = $this->getResource()->getTable('mymodule_product_label');
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['pid']
        )
            ->where(
                'lid = ?',
                (int)$object->getId()
            );

        return $this->getResource()->getConnection()->fetchCol($select);
    }
}