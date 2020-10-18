<?php
namespace Olegnax\Athlete2\Plugin\Catalog\Block\Product\View\Details;

/**
 * Interceptor class for @see \Olegnax\Athlete2\Plugin\Catalog\Block\Product\View\Details
 */
class Interceptor extends \Olegnax\Athlete2\Plugin\Catalog\Block\Product\View\Details implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Olegnax\Athlete2\Helper\Helper $helper, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $helper, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function toHtml()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'toHtml');
        if (!$pluginInfo) {
            return parent::toHtml();
        } else {
            return $this->___callPlugins('toHtml', func_get_args(), $pluginInfo);
        }
    }
}
