<?php
namespace CRep\Sales\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

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
        //print_r($dataSource);
        //$url = $this->_urlBuilder->getUrl('crep_sales/product/full');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $url = $this->_urlBuilder->getUrl('crep_sales/product/full', array('sku'=>$item[$this->getData('name')]));
                $item[$this->getData('name')] = "<a href='$url'>".$item[$this->getData('name')]."</a>";
            }
        }
        return $dataSource;
    }
}