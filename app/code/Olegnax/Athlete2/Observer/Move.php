<?php

namespace Olegnax\Athlete2\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Model\ScopeInterface;
use Olegnax\Athlete2\Helper\Helper;

class Move implements ObserverInterface
{
    protected $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function execute(Observer $observer)
    {
        if (!$this->getConfig(Helper::XML_ENABLED)) {
            return;
        }
        $layout = $observer->getData('layout');
		/* move minicart in header 1*/
		$headerLayout = $this->getConfig('athlete2_settings/header/header_layout');
		if($headerLayout == 'header_1'){
			$layout->getUpdate()->addHandle('olegnax_athlete2_header_move_minicart');
		}
        $fullActionName = $observer->getData('full_action_name');

        if (in_array($fullActionName, [
            'checkout_index_index',
            'contact_index_index',
            'customer_account_create',
            'customer_account_forgotpassword',
            'customer_account_login',
        ])) {
            $layout->getUpdate()->addHandle('olegnax_athlete2_recaptcha_duplicate_remove');
        }

		 if ($fullActionName == 'catalog_category_view') {
			if($this->getConfig('athlete2_settings/products_listing/move_cat_title')){
				$layout->getUpdate()->addHandle('olegnax_athlete2_category_move_title');
			}
			/*
			if($this->getConfig('athlete2_settings/products_listing/move_breadrumbs')){
				$layout->getUpdate()->addHandle('olegnax_athlete2_category_move_breadcrumbs');
			}
			if($this->getConfig('athlete2_settings/products_listing/move_image')){
				$layout->getUpdate()->addHandle('olegnax_athlete2_category_move_image');
			}
			if($this->getConfig('athlete2_settings/products_listing/move_desc')){
				$layout->getUpdate()->addHandle('olegnax_athlete2_category_move_desc');
			}*/
		 }
		 if (!in_array($fullActionName, ['catalog_product_view', 'ox_quickview_catalog_product_view'])) {
			 return $this;			 
		 }
			/* move reviews */
			$reviewsInTab = $this->getConfig('athlete2_settings/product/reviews_position');
			if ($reviewsInTab) {
				if($reviewsInTab == 'oxbottom'){
					$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_view_review_oxbottom');
				} elseif($reviewsInTab == 'bottom'){
					$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_view_review_bottom');
				}
			} else{
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_view_move_review');
			}
		
		$tabsInInfo = $this->getConfig('athlete2_settings/product/product_tabs_position');
		/*if($fullActionName == 'ox_quickview_catalog_product_view' && $tabsInInfo == 'info'){
			$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_tabs_remove');
		}*/

			
			if ($tabsInInfo == 'info') {
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_tabs_right');
			} 
			if($tabsInInfo == 'oxbottom'){
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_tabs_oxbottom');
			} 
			if($tabsInInfo == 'bottom'){
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_tabs_bottom');
			}
			
			/* move related */
			$moveRelated = $this->getConfig('athlete2_settings/product/related_positon');
			$moveUpsell  = $this->getConfig('athlete2_settings/product/upsell_positon');
			if ($moveRelated == 'oxbottom') {
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_related_oxbottom');
			} elseif($moveUpsell == 'bottom'){
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_related_bottom');
			}
			if ($moveUpsell == 'oxbottom') {
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_upsell_oxbottom');
			} elseif($moveUpsell == 'bottom'){
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_upsell_bottom');
			}
			/* sticky product, move elements in sticky wrapper */
			$galleryOverride  = $this->getConfig('athlete2_settings/product/gallery_override');
			$galleryLayout  = $this->getConfig('athlete2_settings/product/gallery_layout');
			$stickyDesc  = $this->getConfig('athlete2_settings/product/gallery_sticky');
			$infoWrapper  = $this->getConfig('athlete2_settings/product/gallery_wrapper');
			if(($stickyDesc && $galleryOverride && ($galleryLayout == '1col' || $galleryLayout == '2cols')) || $infoWrapper){
				$layout->getUpdate()->addHandle('olegnax_athlete2_catalog_product_info_wrapper');
			}
		
        return $this;
    }

    public function getConfig($path, $storeCode = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeCode);
    }
}
