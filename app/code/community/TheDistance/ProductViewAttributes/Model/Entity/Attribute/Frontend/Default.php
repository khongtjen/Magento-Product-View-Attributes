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
 * @package     Mage_Eav
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/**
 * Entity/Attribute/Model - attribute frontend model extending core functionality
 *
 * @category   	TheDistance
 * @package    	ProductViewAtrtibutes
 * @author    	Dajve Green <dajve@thedistance.co.uk>
 * @copyright   Copyright (c) 2012 The Distance Agency Ltd. (http://thedistance.co.uk)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
class TheDistance_ProductViewAttributes_Model_Entity_Attribute_Frontend_Default extends Mage_Eav_Model_Entity_Attribute_Frontend_Default {
	
    /**
      * Retrieve attribute value
	  * This overwrites the function in Mage_Eav_Model_Entity_Attribute_Frontend_Abstract without extending 
	  *		and now doesn't select the value "No" if no value has been selected in a select / yes/no field
      *
	  * @since 	TheDistance_ProductViewAttributes 1.0.0
	  * @see 	Mage_Eav_Model_Entity_Attribute_Frontend_Abstract::getValue()
      * @param 	Varien_Object $object
      * @return mixed
      */
    public function getValue(Varien_Object $object) {
        $value = $object->getData($this->getAttribute()->getAttributeCode());
        if (in_array($this->getConfigField('input'), array('select','boolean'))) {
            $value = $this->getOption($value);
        } elseif ($this->getConfigField('input') == 'multiselect') {
            $value = $this->getOption($value);
            if (is_array($value)) {
                $value = implode(', ', $value);
            }
        }

        return $value;
    } /// end function getValue()

} /// end class
