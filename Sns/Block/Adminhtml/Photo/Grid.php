<?php	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 	 

class CosmoCommerce_Sns_Block_Adminhtml_Photo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('imageGrid');
      $this->setDefaultSort('image_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('blog/userimages')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('image_id', array(
          'header'    => Mage::helper('sns')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'image_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('sns')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      $this->addColumn('product_id', array(
          'header'    => Mage::helper('sns')->__('product_id'),
          'align'     =>'left',
          'index'     => 'product_id',
      ));
	  /*
      $this->addColumn('filename', array(
          'header'    => Mage::helper('sns')->__('filename'),
          'align'     =>'left',
          'index'     => 'filename',
      ));
	  */
      $this->addColumn('sort_order', array(
          'header'    => Mage::helper('sns')->__('sort_order'),
          'align'     =>'left',
          'index'     => 'sort_order',
      ));
      $this->addColumn('data1', array(
          'header'    => Mage::helper('sns')->__('data1'),
          'align'     =>'left',
          'index'     => 'data1',
      ));
      $this->addColumn('data2', array(
          'header'    => Mage::helper('sns')->__('data2'),
          'align'     =>'left',
          'index'     => 'data2',
      ));
      $this->addColumn('data3', array(
          'header'    => Mage::helper('sns')->__('data3'),
          'align'     =>'left',
          'index'     => 'data3',
      ));
      $this->addColumn('data4', array(
          'header'    => Mage::helper('sns')->__('data4'),
          'align'     =>'left',
          'index'     => 'data4',
      ));
      $this->addColumn('description', array(
          'header'    => Mage::helper('sns')->__('description'),
          'align'     =>'left',
          'index'     => 'description',
      ));
        $this->addColumn('data5', array(
            'header'    => Mage::helper('customer')->__('头像'),
            'width'     => '70',
            'align' => 'left',
            'renderer' => 'CosmoCommerce_Attributemanager_Block_Adminhtml_Template_Grid_Renderer_Image',
			'type'=>'image',
            'index'     => 'data5'
        ));
		
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('sns')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('sns')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   =>  Mage::getSingleton('sns/status')->getOptionArray()
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('sns')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getImageId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('sns')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('sns')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('sns')->__('XML'));
	  
      return parent::_prepareColumns();
  }
  
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getImageId()));
  }

}