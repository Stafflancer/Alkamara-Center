<?php
namespace MultiSafepay\Connect\Controller\Connect\Cancel;

/**
 * Interceptor class for @see \MultiSafepay\Connect\Controller\Connect\Cancel
 */
class Interceptor extends \MultiSafepay\Connect\Controller\Connect\Cancel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Sales\Api\Data\OrderInterfaceFactory $orderFactory, \Magento\Checkout\Model\Session $session, \Magento\Quote\Api\CartRepositoryInterface $cartRepository, \MultiSafepay\Connect\Helper\Data $helperData, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $orderFactory, $session, $cartRepository, $helperData, $orderRepository);
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
