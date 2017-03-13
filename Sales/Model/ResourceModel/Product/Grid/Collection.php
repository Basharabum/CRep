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
        $this->addFilterToMap('entity_id','main_table.entity_id');
        
        //$this->addFieldToSelect('entity_id');
        //$this->addFieldToFilter('sku','MM620V2016'); //Фильтр по SKU
        //$this->addFieldToFilter('created_at', array('gt' => date("Y-m-d H:i:s", strtotime('-30 day'))));
        /*$params = $this->_request->getPost();
        print_r($params);*/
        /* $sku = $this->_request->getParam('sku');
       
         /*$this->clear();
           $this->load();*/
           /* $params = $this->getFilter();
            print_r($params);*/
            /*$params = $this->_request->getPost();
            print_r($params);*/
            
            
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
  
    protected function _renderFiltersBefore() 
    {
        $salesOrderItemTable = $this->getTable('sales_order_item');



       /*$this->getSelect()

                        ->columns('SUM(base_grand_total) as base_grand_total')
                        ->columns('SUM(base_shipping_amount) as base_shipping_amount')
                        ->columns('COUNT(*) as items_sold')
                        ->columns('MIN(item.created_at) as created_at')
                        ->join($salesOrderItemTable.' as item','main_table.entity_id = item.order_id', array('sku','name'))
                        ->group('sku');*/

/*->columns('SUM(base_grand_total) as base_grand_total')
                        ->columns('SUM(base_shipping_amount) as base_shipping_amount')
                        ->columns('COUNT(*) as items_sold')
                        ->columns('MAX(main_table.created_at) as created_at')
                        ->join($salesOrderItemTable.' as item','main_table.entity_id = item.order_id', array('sku','name'))
                        ->group('sku');*/

        $this->_logger->addDebug($this->getSelect()
                        ->columns('SUM(main_table.base_grand_total) as base_grand_total')
                        ->columns('SUM(main_table.base_shipping_amount) as base_shipping_amount')
                        ->columns('COUNT(*) as items_sold')
                        ->columns('MAX(item.created_at) as created_at')
                        ->join($salesOrderItemTable.' as item','main_table.entity_id = item.order_id', array('sku','name'))
                        ->group('sku'));

        parent::_renderFiltersBefore();
    }
}