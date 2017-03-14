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
        //$this->_logger->addDebug("Дата: ".$createdAt);
        
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

    //Функция применяет фильтр по дате, переданный методом GET
    protected function applyDateFilter()
    {
        $createdAt = $this->_request->getParam('created_at');

        if ($createdAt == null) {
            
            if (isset($_SERVER["HTTP_REFERER"])) {
                $refer = $_SERVER["HTTP_REFERER"];
                $keyStart = strpos($refer,'created_at');
                if ($keyStart != FALSE) { 
                    //фильтр по дате есть в реф. ссылке
                    $valueStart = $keyStart + strlen('created_at') + 1;
                    $valueEnd = strpos($refer, '/',$valueStart);
                    
                    if ($valueEnd == FALSE) { 
                        //фильтр по дате в конце ссылки
                        $valueEnd = strlen($refer);
                    }
                    
                    $createdAt = substr($refer, $valueStart, $valueEnd);
                }
                else {
                    return; //фильтра по дате нет
                }
            }
        }
       
        $dateFrom = substr($createdAt, 0, strpos($createdAt, '-'));
        $dateFrom = str_replace('_', '/', $dateFrom)." 05:00:00";
        
        $dateTo = substr($createdAt, strpos($createdAt, '-') + 1);
        $dateTo = str_replace('_', '/', $dateTo)." 04:59:59";
           
        if($dateFrom != '...') {
        $this->addFieldToFilter('created_at', array('gteq' => date("Y-m-d H:i:s", strtotime($dateFrom))));
        }
        if($dateTo != '...') {
        $this->addFieldToFilter('created_at', array('lteq' => date("Y-m-d H:i:s", strtotime($dateTo)))); 
        }
    }

    protected function _renderFiltersBefore()
    {
        $this->applyDateFilter();
        $salesOrderItemTable = $this->getTable('sales_order_item');
        $customerAddressEntityTable = $this->getTable('customer_address_entity');
        $salesOrderPaymentTable = $this->getTable('sales_order_payment');
     
        //$this->_logger->addDebug(
            $this->getSelect()
                  ->join($salesOrderItemTable.' as item','main_table.entity_id = item.order_id', array('sku','name','price'))
                  ->joinLeft($customerAddressEntityTable.' as address','main_table.customer_id = address.parent_id', array('street','city','country_id','postcode','telephone'))
                  ->joinLeft($salesOrderPaymentTable.' as payment','main_table.entity_id = payment.parent_id', array('method'));
        //);
        parent::_renderFiltersBefore();
    }
}