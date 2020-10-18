<?php
namespace Olegnax\MegaMenu\Block\Html\Megamenu;

/**
 * Interceptor class for @see \Olegnax\MegaMenu\Block\Html\Megamenu
 */
class Interceptor extends \Olegnax\MegaMenu\Block\Html\Megamenu implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Data\Tree\NodeFactory $nodeFactory, \Magento\Framework\Data\TreeFactory $treeFactory, array $data = [])
    {
        $this->___init();
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKeyInfo()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCacheKeyInfo');
        if (!$pluginInfo) {
            return parent::getCacheKeyInfo();
        } else {
            return $this->___callPlugins('getCacheKeyInfo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getHtml');
        if (!$pluginInfo) {
            return parent::getHtml($outermostClass, $childrenWrapClass, $limit);
        } else {
            return $this->___callPlugins('getHtml', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIdentities');
        if (!$pluginInfo) {
            return parent::getIdentities();
        } else {
            return $this->___callPlugins('getIdentities', func_get_args(), $pluginInfo);
        }
    }
}
