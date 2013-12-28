<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;
    const STATUS_VERIFIED	= 3;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('sns')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('sns')->__('Disabled'),
            self::STATUS_VERIFIED   => Mage::helper('sns')->__('Verified')
        );
    }
	
    static public function getOptionArray2()
    {
        return array(
            array(
				'value'=>self::STATUS_ENABLED,
				'label'=>Mage::helper('sns')->__('Enabled'),
			),
            array(
				'value'=>self::STATUS_DISABLED,
				'label'=>Mage::helper('sns')->__('Disabled'),
			),
            array(
				'value'=>self::STATUS_VERIFIED,
				'label'=>Mage::helper('sns')->__('Verified'),
			),
        );
    }
	
}