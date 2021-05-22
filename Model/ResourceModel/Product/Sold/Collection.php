<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Report Sold Products collection
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */

namespace AHT\Salesagents\Model\ResourceModel\Product\Sold;

use Magento\Framework\DB\Select;
use Zend_Db_Select_Exception;

/**
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Collection extends \Magento\Reports\Model\ResourceModel\Order\Collection
{
    /**
     * Set Date range to collection
     *
     * @param int $from
     * @param int $to
     * @return $this
     */
    public function setDateRange($from, $to)
    {
        $this->_reset()->addAttributeToSelect(
            '*'
        )->addOrderedQty(
            $from,
            $to
        )->setOrder('ordered_qty', self::SORT_ORDER_DESC);
        return $this;
    }

    /**
     * Add ordered qty's
     *
     * @param string $from
     * @param string $to
     * @return $this
     * @throws Zend_Db_Select_Exception
     */
    public function addOrderedQty($from = '', $to = '')
    {
        $connection = $this->getConnection();
        $orderTableAliasName = $connection->quoteIdentifier('order');

        $orderJoinCondition = [
            $orderTableAliasName . '.entity_id = order_items.order_id',
            $connection->quoteInto("{$orderTableAliasName}.state <> ?", \Magento\Sales\Model\Order::STATE_CANCELED),
        ];

        if ($from != '' && $to != '') {
            $fieldName = $orderTableAliasName . '.created_at';
            $orderJoinCondition[] = $this->prepareBetweenSql($fieldName, $from, $to);
        }

        $this->getSelect()->reset()->from(
            ['order_items' => $this->getTable('sales_order_item')],
            [
                'ordered_qty' => 'SUM(order_items.qty_ordered)',
                'order_items_name' => 'order_items.name',
                'order_items_sku' => 'order_items.sku'
            ]
        )->joinInner(
            ['order' => $this->getTable('sales_order')],
            implode(' AND ', $orderJoinCondition),
            'status',
        )->joinLeft( 
            ['commission_value' => $this->getConnection()->getTableName('catalog_product_entity_decimal')],
            'order_items.product_id = commission_value.entity_id and commission_value.attribute_id = "159"',
            ['sa_commission_value' => 'commission_value.value']
        )
        ->joinLeft( 
            ['commission_type' => $this->getConnection()->getTableName('catalog_product_entity_int')],
            'order_items.product_id = commission_type.entity_id and commission_type.attribute_id = "158"',
            ['sa_commission_type' => 'commission_type.value',]
        )
        ->joinLeft( 
            ['sale_agent' => $this->getConnection()->getTableName('catalog_product_entity_text')],
            'order_items.product_id = sale_agent.entity_id and sale_agent.attribute_id = "157"',
            [   'sale_agent' => 'sale_agent.value',
                ]
        )
        ->where(
            'order_items.parent_item_id IS NULL and sale_agent.value IS NOT NULL'
        )->group(
            'order_items.sku'
        ) 
        ->columns(
            'order_items.base_row_total_incl_tax as product_price_final'
        )
        ->columns(
             'round(order_items.base_price-commission_value.value) as result_commission'
        )
            //  CASE WHEN IDParent < 1 THEN ID ELSE IDPArent END AS ColumnName
        ->having(
            'SUM(order_items.qty_ordered) > ?',
            0
        )
       
        ->order('order.status');
        return $this;
    }

    /**
     * Set store filter to collection
     *
     * @param array $storeIds
     * @return $this
     */
    public function setStoreIds($storeIds)
    {
        if ($storeIds) {
            $this->getSelect()->where('order_items.store_id IN (?)', (array)$storeIds);
        }
        return $this;
    }
    /**
     * @inheritdoc
     *
     * @return Select
     * @since 100.2.0
     */
    public function getSelectCountSql()
    {
        $countSelect = clone parent::getSelectCountSql();

        $countSelect->reset(Select::COLUMNS);
        $countSelect->columns('COUNT(DISTINCT order_items.item_id)');

        return $countSelect;
    }
    /**
     * Set order
     *
     * @param string $attribute
     * @param string $dir
     * @return $this
     */
    public function setOrder($attribute, $dir = self::SORT_ORDER_DESC)
    {
        if (in_array($attribute, ['orders', 'ordered_qty'])) {
            $this->getSelect()->order($attribute . ' ' . $dir);
        } else {
            parent::setOrder($attribute, $dir);
        }

        return $this;
    }

    /**
     * Prepare between sql
     *
     * @param string $fieldName Field name with table suffix ('created_at' or 'main_table.created_at')
     * @param string $from
     * @param string $to
     * @return string Formatted sql string
     */
    protected function prepareBetweenSql($fieldName, $from, $to)
    {
        return sprintf(
            '(%s BETWEEN %s AND %s)',
            $fieldName,
            $this->getConnection()->quote($from),
            $this->getConnection()->quote($to)
        );
    }
}
