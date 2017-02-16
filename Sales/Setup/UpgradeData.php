<?php
 
namespace CRep\Sales\Setup;
 
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
 
class UpgradeData implements UpgradeDataInterface
{
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
 
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            
            $tableName = $setup->getTable('crep_sales_product');
            // Check if the table already exists
            if ($setup->getConnection()->isTableExists($tableName) == true) {
                // Declare data
                $data = [
                    [
                        'sku' => 'MM55',
                        'name' => 'TestName',
                        'units_sold' => 2,
                        'date' => date('Y-m-d H:i:s'),
                        'tax' => 0.0,
                        'revenue_by_qty_abs' => 0.0,
                        'revenue_by_price' => 0.0,
                        'shipping' => 0.0
                    ],
                    [
                        'sku' => 'BB55',
                        'name' => 'Second',
                        'units_sold' => 1,
                        'date' => date('Y-m-d H:i:s'),
                        'tax' => 0.0,
                        'revenue_by_qty_abs' => 0.0,
                        'revenue_by_price' => 0.0,
                        'shipping' => 0.0
                    ]
                ];
 
                // Insert data to table
                foreach ($data as $item) {
                    $setup->getConnection()->insert($tableName, $item);
                }
            }
        }
 
        $setup->endSetup();
    }
}