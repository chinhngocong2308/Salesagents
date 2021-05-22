<?php
namespace AHT\Salesagents\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('aht_sales_agent'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Sales Agent ID'
            )
            ->addColumn(
              'order_id',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              255,
              [
                  'nullable'  => true,
              ],
              'Order id'
          )
            ->addColumn(
                'order_item_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                255,
                [
                    'nullable'  => true,
                ],
                'Order Item id'
            )
            ->addColumn(
                'order_item_price',
                \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
                255,
                [
                    'nullable'  => false,
                ],
                'Order item price'
            )
            ->addColumn(
              'commision_type',
              \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
              255,
              [
                  'nullable'  => true,
              ],
              'Commision Type'
          )
          ->addColumn(
            'commission_value',
            \Magento\Framework\DB\Ddl\Table::TYPE_FLOAT,
            255,
            [
                'nullable'  => false,
            ],
            'Comission Value'
        )
            ->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                  'Created At'
            )
            ->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                null,
                ['nullable' => false],
                  'Updated At'
            )
            ->addIndex(
              $setup->getIdxName('aht_sales_agent', ['entity_id']),
              ['entity_id']
            )
            ->setComment("Sale Agent");
        $installer->getConnection()->createTable($table);

        $installer->endSetup();

    }
}
