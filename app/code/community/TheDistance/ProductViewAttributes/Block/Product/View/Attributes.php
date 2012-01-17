<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Product description block extending core functionality
 *
 * @category   	TheDistance
 * @package    	ProductViewAtrtibutes
 * @author    	Dajve Green <dajve@thedistance.co.uk>
 * @copyright   Copyright (c) 2012 The Distance Agency Ltd. (http://thedistance.co.uk)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TheDistance_ProductViewAttributes_Block_Product_View_Attributes extends Mage_Catalog_Block_Product_View_Attributes {
	
	/** Whether to return attributes without values entered
	  * 
	  * @since 	TheDistance_ProductViewAttributes 1.0.0
	  * @see getShowNull()
	  * @see setShowNull()
	  * @var bool $_showNull
	  */
	protected $_showNull = false;
	
	/** Sets showNull value
	  * 
	  * @since 	TheDistance_ProductViewAttributes 1.0.0
	  * @param	bool $show
	  * @return TheDistance_ProductViewAttributes_Block_Product_View_Attributes
	  */
	public function setShowNull( $show=true ) {
		if ( 'false' === $show ) {
			$show = false;	
		}
		$this->_showNull = (bool)$show;	
		return $this;
	} /// end setShowNull()
	
	/** Returns showNull value
	  * 
	  * @since	TheDistance_ProductViewAttributes 1.0.0
	  * @return bool
	  */
	public function getShowNull() {
		return $this->_showNull;	
	} /// end getShowNull()
	
	
	/** Default value to return if no value entered for attribute
	  * 
	  * @since 	TheDistance_ProductViewAttributes 1.0.0
	  * @see 	getNullValue()
	  * @see 	setNullValue()
	  * @var bool $_showNull
	  */
	protected $_nullValue = "N/A";
	
	/** Sets value to return if no value entered for attribute
	  *
	  * @since 	TheDistance_ProductViewAttributes 1.0.0
	  * @param 	string $value
	  * @return TheDistance_ProductViewAttributes_Block_Product_View_Attributes
	  */
	public function setNullValue( $value="" ) {
		$this->_nullValue = (string)$value;
		return $this;
	} /// end setNullValue()
	
	/** Returns showNull value
	  * 
	  * @since	TheDistance_ProductViewAttributes 1.0.0
	  * @return string
	  */
	public function getNullValue() {
		return $this->_nullValue;	
	} /// end getNullValue()
	
	
    /**
     * $excludeAttr is optional array of attribute codes to
     * exclude them from additional data array
     *
     * @param array $excludeAttr
     * @return array
     */
    public function getAdditionalData( array $excludeAttr = array() ) {
        $data = array();
        $product = $this->getProduct();
        $attributes = $product->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getIsVisibleOnFront() && !in_array($attribute->getAttributeCode(), $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);
				$is_null = false;
				
                if (!$product->hasData($attribute->getAttributeCode()) || (string)$value === "" ) {
					$is_null = true;
					$value = Mage::helper( 'catalog' )->__( $this->getNullValue() );
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = Mage::app()->getStore()->convertPrice($value, true);
                }
				
				if ( ( $is_null && !$this->getShowNull() ) ) {
					continue;	
				}

				$data[$attribute->getAttributeCode()] = array(
					'label' 	=> $attribute->getStoreLabel(),
					'value' 	=> $value,
					'code'  	=> $attribute->getAttributeCode() ,
					'is_null'	=> $is_null ,
				);
            }
        }
        return $data;
    } /// end getAdditionalData()
	
} // end class definition
