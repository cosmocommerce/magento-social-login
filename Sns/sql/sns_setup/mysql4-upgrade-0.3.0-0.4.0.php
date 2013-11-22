<?php
$installer = new Mage_Customer_Model_Entity_Setup('core_setup');
$installer->startSetup();

$installer->addAttribute(
    'customer',
    'weibo_id',
    array(
        'group'                => 'Default',
        'type'                 => 'varchar',
        'label'                => 'Weibo Id',
        'input'                => 'text',
        'source'               => 'eav/entity_attribute_source_text',
        'global'               => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'required'             => 0,
        'default'              => 0,
        'visible'              => 0,
        'adminhtml_only'       => 1,
        'user_defined'  => 1,
    )
);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'weibo_id');
$oAttribute->setData('used_in_forms', array('adminhtml_customer'));
$oAttribute->save();
$installer->endSetup();
$installer = new Mage_Customer_Model_Entity_Setup;
$installer->startSetup();

$installer->addAttribute(
    'customer',
    'qq_id',
    array(
        'group'                => 'Default',
        'type'                 => 'varchar',
        'label'                => 'QQ Id',
        'input'                => 'text',
        'source'               => 'eav/entity_attribute_source_text',
        'global'               => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'required'             => 0,
        'default'              => 0,
        'visible'              => 0,
        'adminhtml_only'       => 1,
        'user_defined'  => 1,
    )
);

$oAttribute = Mage::getSingleton('eav/config')->getAttribute('customer', 'qq_id');
$oAttribute->setData('used_in_forms', array('adminhtml_customer'));
$oAttribute->save();
$installer->endSetup();