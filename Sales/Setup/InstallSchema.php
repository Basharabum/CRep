<?php

namespace CRep\Sales\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
 
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('crep_sales_product')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('crep_sales_product')
            )
            ->addColumn(
                'product_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'product ID'
            )
            ->addColumn(
                'sku',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'SKU'
            )
            ->addColumn(
                'name',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                255,
                ['nullable => false'],
                'Product Name'
            )
            ->addColumn(
                'units_sold',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                0,
                [],
                'Units Sold'
            )
            ->addColumn(
                'date',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Date'
            )
            ->addColumn(
                'tax',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                0.0,
                [],
                'Tax'
            )
            ->addColumn(
                'revenue_by_qty_abs',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                0.0,
                [],
                'Revenue By Qty Abs'
            )
            ->addColumn(
                'revenue_by_price',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                0.0,
                [],
                'Revenue By Price'
            )
            ->addColumn(
                'shipping',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                0.0,
                [],
                'Shipping'
            )
            ->setComment('Last Sales Table');
            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('crep_sales_product'),
                $setup->getIdxName(
                    $installer->getTable('crep_sales_product'),
                    ['sku','name'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['sku','name'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
