<?php

namespace Dtn\Knockout\Controller\Department;
 
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;
 
class Delete extends \Magento\Framework\App\Action\Action
{
 
    protected $helper;
    protected $resultJsonFactory;
    protected $resultRawFactory;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory
    ) {
        parent::__construct($context);
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
    }
    public function execute()
    {
        $model = $this->_objectManager->create('Dtn\Knockout\Model\Department');
        $data = $this->getRequest()->getParams('data');
        $model->load($data['entity_id'])->delete();
        
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($data);
    }
}
