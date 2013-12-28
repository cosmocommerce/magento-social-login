<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_Block_Adminhtml_Sns_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sns';
        $this->_controller = 'adminhtml_sns';
        
        $this->_updateButton('save', 'label', Mage::helper('sns')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('sns')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('sns_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'sns_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'sns_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('sns_data') && Mage::registry('sns_data')->getId() ) {
            return Mage::helper('sns')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('sns_data')->getTitle()));
        } else {
            return Mage::helper('sns')->__('Add Item');
        }
    }
}