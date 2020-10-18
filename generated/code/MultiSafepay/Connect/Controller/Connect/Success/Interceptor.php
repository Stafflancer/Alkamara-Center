<?php
namespace MultiSafepay\Connect\Controller\Connect\Success;

/**
 * Interceptor class for @see \MultiSafepay\Connect\Controller\Connect\Success
 */
class Interceptor extends \MultiSafepay\Connect\Controller\Connect\Success implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Sales\Model\Order $order, \Magento\Checkout\Model\Session $session, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \MultiSafepay\Connect\Model\Connect $connect, \MultiSafepay\Connect\Helper\Data $data)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $order, $session, $invoiceSender, $connect, $data);
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
