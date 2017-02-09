<?php

namespace CRep\Sales\Model;

class Product extends \Magento\Framework\Model\AbstractModel
{
  
    const CACHE_TAG = 'crep_sales_product';

    protected $_cacheTag = 'crep_sales_product';

    protected $_eventPrefix = 'crep_sales_product';

    protected function _construct()
    {
        $this->_init('CRep\Sales\Model\ResourceModel\Product');
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
}
