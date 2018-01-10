<?php
/**
 * User: smart
 * Date: 25-12-2017
 * Time: 11:12 SA
 */

namespace MyModule\Label\Model;

use Magento\Ui\DataProvider\AbstractDataProvider;
use MyModule\Label\Model\ResourceModel\Label\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    protected $_loadedData;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $collectionFactory,
                                array $meta = [], array $data = [])
    {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }
}