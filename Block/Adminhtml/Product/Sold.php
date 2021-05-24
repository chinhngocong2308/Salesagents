<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\Salesagents\Block\Adminhtml\Product;

/**
 * Backend Report Sold Product Content Block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Sold extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @var string
     */
    protected $_blockGroup = 'AHT_Salesagents';

    /**
     * Initialize container block settings
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'AHT_Salesagents';
        $this->_controller = 'adminhtml_product_sold';
        $this->_headerText = __('Products Commission');
        parent::_construct();
        $this->buttonList->remove('add');
    }
}
