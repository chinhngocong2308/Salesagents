<?php

namespace AHT\Salesagents\Controller\Adminhtml\Search;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @param Magento\Framework\App\ResponseInterface
     */
    private $response;

    /**
     * @param Magento\Catalog\Model\ProductFactory
     */
    protected $_productCommissionCollectionFactory;

    /**
     * @param \Magento\Framework\Serialize\Serializer\Json
     */
    private $json;

    /**
     * @param Magento\Framework\Controller\Result\JsonFactory
     */
    private $jsonFactory;

    /**
     * @param Magento\Catalog\Helper\Image
     */
    private $imageHelper;

    /**
     * @param \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Framework\App\ResponseInterface $response,
        \AHT\Salesagents\Model\ResourceModel\Product\Sold\CollectionFactory $productCommissionCollectionFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {

        $this->_pageFactory = $pageFactory;
        $this->response = $response;
        $this->_productCommissionCollectionFactory = $productCommissionCollectionFactory;
        $this->json = $json;
        $this->jsonFactory = $jsonFactory;
        $this->imageHelper = $imageHelper;
        $this->storeManager = $storeManager;
        return parent::__construct($context);
    }
    /**
     * View page action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {

        /* @var \Magento\Framework\Controller\Result\Json $resultJson */
       

        $resultJson = $this->jsonFactory->create();
        return $resultJson->setData($commission);
    }

    public function getCollection()
    {
        $data = $this->getRequest()->getContent();
        $response = $this->json->unserialize($data);

        $search = $response['search'];
        if (!$search) {
            return false;
        }
        $data = $this->_productCommissionCollectionFactorys->create()
            ->addAttributeToSelect('*')->addAttributeToFilter('order_items_sku', [
                'like' => '%' . $search . '%'
            ]);
            // ->setPageSize(2)
            // ->setCurPage(1);
       
        return array_values($data->toArray());
    }
}