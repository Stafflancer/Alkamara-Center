<?php
namespace MultiSafepay\Connect\Controller\Connect\Redirect;

/**
 * Interceptor class for @see \MultiSafepay\Connect\Controller\Connect\Redirect
 */
class Interceptor extends \MultiSafepay\Connect\Controller\Connect\Redirect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Checkout\Model\Session $session, \Magento\Sales\Model\Order $order, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \MultiSafepay\Connect\Model\Connect $mspConnect)
    {
        $this->___init();
        parent::__construct($context, $session, $order, $cartRepository, $mspConnect);
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
