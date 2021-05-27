<?php

namespace AHT\Salesagents\Controller\Adminhtml\Sacommission;
class Index extends \Magento\Backend\App\Action
{
	protected $resultPageFactory;
	protected $helperData;

	public function __construct(
		\Magento\Backend\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->getConfig()->getTitle()->prepend(__('Report Product Commission'));
		return $resultPage;
	}
}
?>