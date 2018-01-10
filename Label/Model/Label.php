<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 10:00 SA
 */

namespace MyModule\Label\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Label extends AbstractModel implements IdentityInterface
{
    const TBL_PRODUCT_LABEL = 'mymodule_product_label';
    const CACHE_TAG         = 'mymodule_label';

    protected $_cacheTag    = 'mymodule_label';
    protected $_eventPrefix = 'mymodule_label';

    protected function _construct()
    {
        $this->_init('MyModule\Label\Model\ResourceModel\Label');
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

    /**
     * Get list id selected product
     *
     * @param Label $label
     *
     * @return array
     */
    public function getProducts(Label $label)
    {
        $tbl    = $this->getResource()->getTable(self::TBL_PRODUCT_LABEL);
        $select = $this->getResource()->getConnection()->select()->from($tbl, ['pid'])
            ->where(
                'lid = ?',
                (int)$label->getId()
            );

        return $this->getResource()->getConnection()->fetchCol($select);
    }
}