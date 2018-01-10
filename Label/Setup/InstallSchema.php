<?php
/**
 * User: smart
 * Date: 21-12-2017
 * Time: 9:39 SA
 */

namespace MyModule\Label\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements  InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('mymodule_label')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mymodule_label')
            )->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary'  => true,
                        'unsigned' => true,
                    ],
                    'Label ID'
                )
                ->addColumn(
                    'code',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false,],
                    'Code Label'
                )
                ->addColumn(
                    'title',
                    Table::TYPE_TEXT,
                    255,
                    ['nullable' => false,],
                    'Title'
                )
                ->addColumn(
                    'position',
                    Table::TYPE_TEXT,
                    50,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Position Label'
                )
                ->addColumn(
                    'is_active',
                    Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false,],
                    'Is Active Label'
                )
                ->addColumn(
                    'created_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [],
                    'Created At'
                )
                ->addColumn(
                    'updated_at',
                    Table::TYPE_TIMESTAMP,
                    null,
                    [],
                    'Updated At'
                )
                ->setComment('Label Table');

            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('mymodule_product_label')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('mymodule_product_label')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'ID'
            )->addColumn(
                    'pid',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Product ID'
                )
                ->addColumn(
                    'lid',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'nullable' => false,
                        'unsigned' => true,
                    ],
                    'Label ID'
                )
                ->setComment('Product Label Table');

            $installer->getConnection()->createTable($table);

            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    'mymodule_product_label', 'pid', 'catalog_product_entity', 'entity_id'
                ),
                $setup->getTable('mymodule_product_label'),
                'pid',
                $setup->getTable('catalog_product_entity'),
                'entity_id',
                Table::ACTION_CASCADE
            );
            $setup->getConnection()->addForeignKey(
                $setup->getFkName(
                    'mymodule_product_label', 'lid', 'mymodule_label', 'id'
                ),
                $setup->getTable('mymodule_product_label'),
                'lid',
                $setup->getTable('mymodule_label'),
                'id',
                Table::ACTION_CASCADE
            );
        }
        $installer->endSetup();
    }
}