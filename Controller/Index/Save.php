<?php

namespace Dtn\Knockout\Controller\Index;
 
use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Exception\LocalizedException;
 
class Save extends \Magento\Framework\App\Action\Action
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
        $data = $this->helper->jsonDecode($this->getRequest()->getContent());
        $id = $data['entity_id'];
        if(!empty($id)) {
            $model = $this->_objectManager->create('Dtn\Knockout\Model\Employee')->load($id);
        } else {
            $model = $this->_objectManager->create('Dtn\Knockout\Model\Employee');
        }
        $save = $model->setEmail($data['email'])->setFirstname($data['firstname'])->setLastname($data['lastname'])->save();
        // $save = $model->setData($data)->save();
        if($save) {
            $response[] = [
                'entity_id' => $model->getId(),
                'email' => $model->getEmail(), 
                'firstname' => $model->getFirstname(), 
                'lastname' => $model->getLastname(), 
            ];
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}
