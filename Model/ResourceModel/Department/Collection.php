<?php

namespace Dtn\Knockout\Model\ResourceModel\Department;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
	protected function _construct()
	{
		$this->_init('Dtn\Knockout\Model\Department', 'Dtn\Knockout\Model\ResourceModel\Department');
	}
}