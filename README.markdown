The way Magento outputs empty attributes in the product view list (specification table) is flawed; this extension seeks to rectify this by hiding empty items, rather than returning either "No" or "N/A".

Installation is simple - copy the app directory to your Magento webroot.

Once installed, you will have access to the following new functions, available programatically or via your layout xml files:

  TheDistance_ProductViewAttributes_Block_Product_View_Attributes::setShowNull( $show )
  TheDistance_ProductViewAttributes_Block_Product_View_Attributes::getShowNull()
  
which switches display of empty items on or off. The default value for this is false.

  TheDistance_ProductViewAttributes_Block_Product_View_Attributes::setNullValue( $value ) 
  TheDistance_ProductViewAttributes_Block_Product_View_Attributes::getNullValue()
  
which defines the value to be returned for null values if they are being returned (ie setShowNull is set to true ).

To set these in your layout files, simply locate the definitions for "catalog/product_view_attributes" blocks to the relevant xml file(s) (usually catalog.xml). For example:

	<block type="catalog/product_view_attributes" name="product.info.attributes" as="product_attributes_data"  template="catalog/product/view/attributes.phtml" />

may become
	
	<block type="catalog/product_view_attributes" name="product.info.attributes" as="product_attributes_data"  template="catalog/product/view/attributes.phtml">
		<action method='setShowNull'><show>true</show></action>
		<action method='setNullValue'><value><![CDATA[<em>Not set</em>]]></value></action>
	</block>