<?php

namespace CRep\Sales\Model\ResourceModel\Product\Grid;

class CollectionFull extends \CRep\Sales\Model\ResourceModel\Product\Collection implements \Magento\Framework\Api\Search\SearchResultInterface
{

    protected $_aggregations;
    protected $_request;
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Framework\App\Request\Http $request,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    )
    {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
        $this->_request = $request;
        ini_set('display_errors',1);
        $this->addFilterToMap('created_at','main_table.created_at');
        $this->addFilterToMap('entity_id','main_table.entity_id');
        $sku = $this->_request->getParam('sku');
        //var_dump($sku);
        if ($sku != NULL) {
           $this->addFieldToFilter('sku',$sku); 
            //$this->addAttributeToFilter('sku',$sku);
        }

    }

    public function getAggregations()
    {
        return $this->_aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->_aggregations = $aggregations;
    }

    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }


    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }

    public function setItems(array $items = null)
    {
        return $this;
    }

    protected function _renderFiltersBefore() {
        
        
        $salesOrderItemTable = $this->getTable('sales_order_item');
        $customerAddressEntityTable = $this->getTable('customer_address_entity');
        $this->getSelect()
        ->join($salesOrderItemTable.' as item','main_table.entity_id = item.order_id', array('sku','name'))
        ->joinLeft($customerAddressEntityTable.' as address','main_table.customer_id = address.parent_id', array('street','city','country_id','postcode','telephone'));
    
    parent::_renderFiltersBefore();
    }
}