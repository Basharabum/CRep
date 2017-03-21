<?php

namespace CRep\Sales\Model\ResourceModel\Product\Grid;

class Collection extends \CRep\Sales\Model\ResourceModel\Product\Collection implements \Magento\Framework\Api\Search\SearchResultInterface
{

    protected $_aggregations;
    protected $_request;
    protected $_logger;
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
        $this->addFilterToMap('item_id','main_table.item_id');

        
        
            
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
    public function addCustomIndexes()
    {
        $this->getConnection()->addIndex(
                    'sales_order_item', //table name
                    'sku',    // index name
                    [
                        'sku',
                        'name'  // filed or column name 
                    ],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT //type of index
                );
    }
    protected function _renderFiltersBefore() 
    {
        $this->addCustomIndexes();
        //$salesOrderItemTable = $this->getTable('sales_order_item');
        $salesOrderTable = $this->getTable('sales_order');

        $this->_logger->addDebug($this->getSelect()
                        ->columns('SUM(price) as item_price')
                        ->columns('SUM(tax_amount) as item_tax')
                        ->columns('COUNT(*) as items_sold')
                        ->columns('MAX(created_at) as created_at')
                        ->group('sku'));


        parent::_renderFiltersBefore();
    }
}