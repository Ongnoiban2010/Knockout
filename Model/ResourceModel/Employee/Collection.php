<?php

namespace Dtn\Knockout\Model\ResourceModel\Employee;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	protected $_idFieldName = 'entity_id';
	
	protected function _construct()
	{
		$this->_init('Dtn\Knockout\Model\Employee', 
			'Dtn\Knockout\Model\ResourceModel\Employee');
	}
}