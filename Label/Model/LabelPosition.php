<?php
/**
 * Created by PhpStorm.
 * User: dangnd
 * Date: 28/12/2017
 * Time: 15:11
 */

namespace MyModule\Label\Model;

use Magento\Framework\Option\ArrayInterface;

class LabelPosition implements ArrayInterface
{

    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => 'Top - Left',
                'value' => 'top-left'
            ],
            [
                'label' => 'Top - Right',
                'value' => 'top-right'
            ],
            [
                'label' => 'Bottom - Right',
                'value' => 'bottom-right'
            ],
            [
                'label' => 'Bottom - Left',
                'value' => 'bottom-left',
            ],
        ];
    }
}