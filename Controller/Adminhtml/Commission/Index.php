<?php

namespace AHT\Salesagents\Controller\Adminhtml\Commission;
use Magento\Reports\Model\Flag;
class Index  extends \Magento\Reports\Controller\Adminhtml\Report\Sales
{
    /**
     * execute the action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $entityAttribute = $objectManager->get('AHT\Salesagents\Model\ResourceModel\Product\Sold\Collection');

        // $entityAttribute->addOrderedQty()->getData();

        $this->_initAction()->_setActiveMenu(
            'AHT_Salesagents::commission'
        )->_addBreadcrumb(
            __('Products Commission'),
            __('Products Commission')
        );
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $entityAttribute = $objectManager->get('AHT\Salesagents\Model\ResourceModel\Product\Sold\Collection');
        // $attributeId = $entityAttribute->addOrderedQty()->getData();

        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Products Commission Report'));
        $this->_view->renderLayout();

    }
    
}
