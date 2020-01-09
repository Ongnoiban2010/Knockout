<?php
namespace Dtn\Knockout\Block;

use Dtn\Knockout\Model\DepartmentFactory;

class Department extends \Magento\Framework\View\Element\Template
{
    protected $layoutProcessors;
    protected $departmentFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $layoutProcessors = [],
        array $data = [],
        DepartmentFactory $departmentFactory
    ) {
        parent::__construct($context);
        $this->layoutProcessors = $layoutProcessors;
        $this->departmentFactory = $departmentFactory;
    }

    public function getJsLayout () {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return parent::getJsLayout();
    }

    public function getDepartmentJson()
    {
        $departmentData = [];
        $department = $this->departmentFactory->create()->getCollection();
        foreach ($department as $item) {
            $departmentData[] = $item->getData();
        }
        return json_encode($departmentData);
    }
}