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

        $this->_initAction()->_setActiveMenu(
            'AHT_Salesagents::commission'
        )->_addBreadcrumb(
            __('Products Commission'),
            __('Products Commission')
        );
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Products Commission Salesagent'));
        $this->_view->renderLayout();
    }

}
