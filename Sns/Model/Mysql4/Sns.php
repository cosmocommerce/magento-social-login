<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_Model_Mysql4_Sns extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the sns_id refers to the key field in your database table.
        $this->_init('sns/sns', 'sns_id');
    }
}