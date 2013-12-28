<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_Block_Adminhtml_Sns_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('sns_form', array('legend'=>Mage::helper('sns')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('sns')->__('Username'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'text', array(
          'label'     => Mage::helper('sns')->__('Date'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('sns')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('sns')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('sns')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('sns')->__('Details'),
          'title'     => Mage::helper('sns')->__('Details'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getSnsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSnsData());
          Mage::getSingleton('adminhtml/session')->setSnsData(null);
      } elseif ( Mage::registry('sns_data') ) {
          $form->setValues(Mage::registry('sns_data')->getData());
      }
      return parent::_prepareForm();
  }
}