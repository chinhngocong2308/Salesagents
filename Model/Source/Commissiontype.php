<?php
namespace AHT\Salesagents\Model\Source;

class Commissiontype extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource 
{
    public function getAllOptions() {
        if ($this->_options === null) {
            $this->_options = [
                ['label' => __('--Fixel/Percent--'), 'value' => ''],
                ['label' => __('Fixel'), 'value' => 1],
                ['label' => __('Percent'), 'value' => 2]
            ];
        }
        return $this->_options;
    }
}