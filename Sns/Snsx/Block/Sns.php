<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 
class CosmoCommerce_Sns_Block_Sns extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSns()     
     { 
        if (!$this->hasData('sns')) {
            $this->setData('sns', Mage::registry('sns'));
        }
        return $this->getData('sns');
        
    }
}