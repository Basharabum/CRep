<?php
namespace CRep\Sales\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;
use Magento\Sales\Model\ResourceModel\Order\Status\CollectionFactory;

class Skulinks extends Column
{
    protected $_resource;
    protected $_scopeConfig;
    protected $_urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
  
    public function prepareDataSource(array $dataSource)
    {
        $url = $this->_urlBuilder->getUrl('crep_sales/product/full');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = "<a href='$url'>".$item[$this->getData('name')]."</a>";
            }
        }
        return $dataSource;
    }
}