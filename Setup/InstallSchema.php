<?php
/**
 * Copyright © 2019 Cubo. All rights reserved.
 * See https://cubo.agency/
**/

namespace Cubo\Multicurrency\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
    * {@inheritdoc}
    * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
    */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
          /**
          * Create table 'greeting_message'
          */
          $table = $setup->getConnection()
              ->newTable($setup->getTable('cubo_multicurrency_manufacturers'))
              ->addColumn(
                  'manufacturer_label',
                  \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                  255,
                  ['default' => ''],
                  'Manufacturer Label'
              )
              ->addColumn(
                  'manufacturer_rates',
                  \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                  '10,4',
                  ['nullable' => false, 'default' => 0.0000],
                  'Manufacturer Currency Rates'
              )->setComment("Manufacturers Table");
          $setup->getConnection()->createTable($table);
      }
}
