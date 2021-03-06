<?php

namespace Dtn\Knockout\Controller\Department;

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
		if($id) {
			$model = $this->_objectManager->create('Dtn\Knockout\Model\Department')->load($id);
		} else {
			$model = $this->_objectManager->create('Dtn\Knockout\Model\Department');
		}
	    $save = $model->setName($data['name'])->save();
	    if($save) {
	    	$response[] = [
                'entity_id' => $model->getId(),
                'name' => $model->getName(), 
            ];
	    }
	    $resultJson = $this->resultJsonFactory->create();
	    return $resultJson->setData($response);
	}
}