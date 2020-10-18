<?php
namespace MultiSafepay\Connect\Controller\Fastcheckout\Cancel;

/**
 * Interceptor class for @see \MultiSafepay\Connect\Controller\Fastcheckout\Cancel
 */
class Interceptor extends \MultiSafepay\Connect\Controller\Fastcheckout\Cancel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Checkout\Model\Session $session, \Magento\Sales\Model\Order $order, \Magento\Quote\Api\CartRepositoryInterface $cartRepositoryInterface, \MultiSafepay\Connect\Helper\Data $data)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $session, $order, $cartRepositoryInterface, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
