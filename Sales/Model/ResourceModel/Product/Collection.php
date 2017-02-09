<?php

namespace CRep\Sales\Model\ResourceModel\Product;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
   
    protected $_idFieldName = 'product_id';

    protected $_eventPrefix = 'crep_sales_product_collection';

    protected $_eventObject = 'product_collection';

    protected function _construct()
    {
        $this->_init('CRep\Sales\Model\Product', 'CRep\Sales\Model\ResourceModel\Product');
    }

    public function getSelectCountSql()
    {
        $countSelect = parent::getSelectCountSql();
        $countSelect->reset(\Zend_Db_Select::GROUP);
        return $countSelect;
    }

    protected function _toOptionArray($valueField = 'product_id', $labelField = 'name', $additional = [])
    {
        return parent::_toOptionArray($valueField, $labelField, $additional);
    }
}
