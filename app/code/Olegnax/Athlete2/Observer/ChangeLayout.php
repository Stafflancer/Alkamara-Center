<?php
/**
 * Set layout
 *
 * @category    Olegnax
 * @package     Olegnax_Athlete2
 * @copyright   Copyright (c) 2020 Olegnax (http://www.olegnax.com/)
 * @license     https://www.olegnax.com/license
 */

namespace Olegnax\Athlete2\Observer;

use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\Product;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Cms\Model\Page;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Page\Config;
use Olegnax\Athlete2\Helper\Helper;

class ChangeLayout implements ObserverInterface
{

    protected $config;
    /**
     * @var RequestInterface
     */
    private $_request;
    /**
     * @var Helper
     */
    private $_helper;
    /**
     * @var Registry
     */
    private $_registry;
    /**
     * @var PageRepositoryInterface
     */
    private $_pageRepository;

    /**
     * ChangeLayout constructor.
     * @param Config $config
     * @param RequestInterface $request
     * @param Registry $registry
     * @param Helper $helper
     */
    public function __construct(
        Config $config,
        RequestInterface $request,
        Registry $registry,
        PageRepositoryInterface $pageRepository,
        Helper $helper
    ) {
        $this->config = $config;
        $this->_request = $request;
        $this->_registry = $registry;
        $this->_pageRepository = $pageRepository;
        $this->_helper = $helper;
    }

    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $variable = '';
        $actionName = $this->_request->getFullActionName();
        switch ($actionName) {
            case 'catalog_category_view':
                $category = $this->getCurrentCategory();
                $customUseParentSettings = !$category->getData('custom_use_parent_settings');
                $catalogPageLayout = $this->getConfig('products_listing/catalog_page_layout');
                if ($category) {
                    if ($customUseParentSettings) {
                        $variable = $category->getData('page_layout') ?: $catalogPageLayout;
                    }
                } else {
                    $variable = $catalogPageLayout;
                }
                break;
            case 'cms_page_view':
                $page = $this->getCurrentPage();
                $cmsPageLayout = $this->getConfig('cms_pages/cms_page_layout');
                if ($page) {
                    $variable = $page->getData('page_layout') ?: $cmsPageLayout;
                } else {
                    $variable = $cmsPageLayout;
                }
                break;
            case 'catalogsearch_result_index':
                $variable = $this->getConfig('products_listing/search_results_layout');
                break;
            case 'catalog_product_view':
                $product = $this->getCurrentProduct();
                $productPageLayout = $this->getConfig('product/product_page_layout');
                if ($product) {
                    $variable = $product->getData('page_layout') ?: $productPageLayout;
                } else {
                    $variable = $productPageLayout;
                }
                break;
        }

        if (!empty($variable)) {
            $this->config->setPageLayout($variable);
        }
    }

    /**
     * @return Category
     */
    public function getCurrentCategory()
    {
        return $this->_registry->registry('current_category') ?: $this->_registry->registry('category');
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getConfig($path = '')
    {
        return $this->_helper->getModuleConfig($path);
    }

    /**
     * @return Page
     */
    public function getCurrentPage()
    {
        try {
            $pageId = $this->_request->getParam('page_id', $this->_request->getParam('id', false));
            return $this->_pageRepository->getById($pageId);
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    /**
     * @return Product
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product') ?: $this->_registry->registry('product');
    }

}
