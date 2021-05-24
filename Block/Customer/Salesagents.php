<?php

namespace AHT\Salesagents\Block\Customer;

class Salesagents extends \Magento\Framework\View\Element\Template
{
    protected $_productCollectionFactory;
    protected $_customerSession;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $customerId = $this->_customerSession->getCustomer()->getId();
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*')->addFieldToFilter('sale_agent_id', $customerId);
        $collection->setPageSize(5);
        return $collection;
    }
}
