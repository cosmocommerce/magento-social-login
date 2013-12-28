<?php
class CosmoCommerce_Sns_Block_Adminhtml_Photo_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('photo_form', array('legend'=>Mage::helper('sns')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('sns')->__('Username'),
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('product_id', 'text', array(
          'label'     => Mage::helper('sns')->__('product_id'),
          'required'  => false,
          'name'      => 'product_id',
	  ));
      $fieldset->addField('data1', 'text', array(
          'label'     => Mage::helper('sns')->__('data1'),
          'required'  => false,
          'name'      => 'data1',
	  ));
      $fieldset->addField('data2', 'text', array(
          'label'     => Mage::helper('sns')->__('data2'),
          'required'  => false,
          'name'      => 'data2',
	  ));
      $fieldset->addField('data3', 'text', array(
          'label'     => Mage::helper('sns')->__('data3'),
          'required'  => false,
          'name'      => 'data3',
	  ));
      $fieldset->addField('data4', 'text', array(
          'label'     => Mage::helper('sns')->__('data4'),
          'required'  => false,
          'name'      => 'data4',
	  ));
      $fieldset->addField('description', 'text', array(
          'label'     => Mage::helper('sns')->__('description'),
          'required'  => false,
          'name'      => 'description',
	  ));
		
	$fieldset->addField('data5', 'image',array(
		'label'    => Mage::helper('sns')->__('头像'),
		'renderer' => 'CosmoCommerce_Attributemanager_Block_Adminhtml_Template_Grid_Renderer_Image',
		'name'     => 'data5'
	));

		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('sns')->__('Status'),
          'name'      => 'status',
          'values'    => Mage::getSingleton('sns/status')->getOptionArray2(),
      ));
     
	 
	 
      if ( Mage::getSingleton('adminhtml/session')->getPhotoData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPhotoData());
          Mage::getSingleton('adminhtml/session')->setPhotoData(null);
      } elseif ( Mage::registry('photo_data') ) {
          $form->setValues(Mage::registry('photo_data')->getData());
      }
      return parent::_prepareForm();
  }
}