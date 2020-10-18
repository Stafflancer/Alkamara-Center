<?php
namespace MultiSafepay\Connect\Controller\Connect\Notification;

/**
 * Interceptor class for @see \MultiSafepay\Connect\Controller\Connect\Notification
 */
class Interceptor extends \MultiSafepay\Connect\Controller\Connect\Notification implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Checkout\Model\Session $session, \Magento\Sales\Model\Order $order, \MultiSafepay\Connect\Helper\Data $data, \MultiSafepay\Connect\Model\Connect $connect, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistryProvider, \MultiSafepay\Connect\Model\MultisafepayTokenizationFactory $tokenizationFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $session, $order, $data, $connect, $invoiceSender, $storeManager, $stockRegistryProvider, $tokenizationFactory);
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
