<?php
namespace Dtn\Knockout\Block;

use Dtn\Knockout\Model\EmployeeFactory;

class Display extends \Magento\Framework\View\Element\Template
{
    protected $layoutProcessors;
    protected $employeeFactory;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $layoutProcessors = [],
        array $data = [],
        EmployeeFactory $employeeFactory
    ) {
        parent::__construct($context);
        $this->layoutProcessors = $layoutProcessors;
        $this->employeeFactory = $employeeFactory;
    }

    public function getAbc(){
        return "Block function abc";
    }

    public function abcxyz(){
        return "Block testjs";
    }

    public function setAbcxyz(){
        return "xxx";
    }

    public function xyz(){
        return null;
    }

    public function getJsLayout () {
        foreach ($this->layoutProcessors as $processor) {
            $this->jsLayout = $processor->process($this->jsLayout);
        }
        return parent::getJsLayout();
    }

    public function getEmployeeCollection()
    {
        $employee = $this->employeeFactory->create()->getCollection();
        return $employee;
    }

    public function getEmployeeJson()
    {
        $employeeData = [];
        $employee = $this->employeeFactory->create()->getCollection();
        foreach ($employee as $item) {
            $employeeData[] = $item->getData();
        }
        return json_encode($employeeData);
    }
}