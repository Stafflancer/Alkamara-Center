<?php
namespace Olegnax\ProductSlider\Block\OnSaleProducts;

/**
 * Interceptor class for @see \Olegnax\ProductSlider\Block\OnSaleProducts
 */
class Interceptor extends \Olegnax\ProductSlider\Block\OnSaleProducts implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory, \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility, \Magento\Framework\App\Http\Context $httpContext, \Magento\Framework\Url\Helper\Data $urlHelper, array $data = [], ?\Magento\Framework\View\LayoutFactory $layoutFactory = null, ?\Magento\Framework\Serialize\Serializer\Json $json = null)
    {
        $this->___init();
        parent::__construct($context, $productCollectionFactory, $catalogProductVisibility, $httpContext, $urlHelper, $data, $layoutFactory, $json);
    }

    /**
     * {@inheritdoc}
     */
    public function isRedirectToCartEnabled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isRedirectToCartEnabled');
        if (!$pluginInfo) {
            return parent::isRedirectToCartEnabled();
        } else {
            return $this->___callPlugins('isRedirectToCartEnabled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImage($product, $imageId, $attributes = [])
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImage');
        if (!$pluginInfo) {
            return parent::getImage($product, $imageId, $attributes);
        } else {
            return $this->___callPlugins('getImage', func_get_args(), $pluginInfo);
        }
    }
}
