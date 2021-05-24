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
        if (!$installer->tableExists('commission_type')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('commission_type')
            )
                ->addColumn(
                    'type_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    255,
                    [
                        'identity'  => true,
                        'unsigned'  => true,
                        'nullable'  => false,
                        'primary'   => true,
                    ],
                    'Id'
                )
                
                ->addColumn(
                    'type_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [
                        'nullable'  => false,
                    ],
                    'Type Name'
                );
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
