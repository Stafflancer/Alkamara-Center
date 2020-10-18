<?php
namespace Magento\Bundle\Block\Adminhtml\Catalog\Product\Composite\Fieldset\Bundle;

/**
 * Interceptor class for @see \Magento\Bundle\Block\Adminhtml\Catalog\Product\Composite\Fieldset\Bundle
 */
class Interceptor extends \Magento\Bundle\Block\Adminhtml\Catalog\Product\Composite\Fieldset\Bundle implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Stdlib\ArrayUtils $arrayUtils, \Magento\Catalog\Helper\Product $catalogProduct, \Magento\Bundle\Model\Product\PriceFactory $productPrice, \Magento\Framework\Json\EncoderInterface $jsonEncoder, \Magento\Framework\Locale\FormatInterface $localeFormat, array $data = [], ?\Magento\CatalogRule\Model\ResourceModel\Product\CollectionProcessor $catalogRuleProcessor = null)
    {
        $this->___init();
        parent::__construct($context, $arrayUtils, $catalogProduct, $productPrice, $jsonEncoder, $localeFormat, $data, $catalogRuleProcessor);
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
