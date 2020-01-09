<?php

namespace Dtn\Knockout\Model;

use Magento\Framework\Model\AbstractModel;

class Department extends AbstractModel
{
	protected function _construct()
	{
		$this->_init('Dtn\Knockout\Model\ResourceModel\Department');
	}
}