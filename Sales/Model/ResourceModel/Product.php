<?php

namespace CRep\Sales\Model\ResourceModel;

class Product extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
  
    protected $_date;

    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        $this->_date = $date;
        parent::__construct($context);
    }


    protected function _construct()
    {
        $this->_init('sales_order', 'entity_id');
    }

    public function getProductNameById($id)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), 'name')
            ->where('entity_id = :entity_id');
        $binds = ['entity_id' => (int)$id];
        return $adapter->fetchOne($select, $binds);
    }

    protected function _beforeSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $object->setUpdatedAt($this->_date->date());
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->_date->date());
        }
        return parent::_beforeSave($object);
    }
}
