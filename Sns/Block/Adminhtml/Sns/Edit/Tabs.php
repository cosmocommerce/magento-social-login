<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_Block_Adminhtml_Sns_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('sns_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sns')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sns')->__('Item Information'),
          'title'     => Mage::helper('sns')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('sns/adminhtml_sns_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}