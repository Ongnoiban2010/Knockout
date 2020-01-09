<?php

namespace Dtn\Knockout\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Department extends AbstractDb
{
	protected function _construct()
	{
		$this->_init('dtn_department', 'entity_id');
	}
}