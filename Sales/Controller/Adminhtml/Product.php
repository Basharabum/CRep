<?php

namespace CRep\Sales\Controller\Adminhtml;

abstract class Product extends \Magento\Backend\App\Action
{
    protected $_productFactory;
   
    protected $_coreRegistry;
    
    protected $_resultRedirectFactory;

   
    public function __construct(
        \CRep\Sales\Model\productFactory $productFactory,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_productFactory           = $productFactory;
        $this->_coreRegistry          = $coreRegistry;
        $this->_resultRedirectFactory = $resultRedirectFactory;
        parent::__construct($context);
    }
    
    protected function _initProduct()
    {
        $productId  = (int) $this->getRequest()->getParam('product_id');
        $product    = $this->_productFactory->create();
        if ($productId) {
            $product->load($productId);
        }
        $this->_coreRegistry->register('crep_sales_product', $product);
        return $product;
    }
}
