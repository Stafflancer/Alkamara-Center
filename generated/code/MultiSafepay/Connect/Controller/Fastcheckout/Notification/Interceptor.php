<?php
namespace MultiSafepay\Connect\Controller\Fastcheckout\Notification;

/**
 * Interceptor class for @see \MultiSafepay\Connect\Controller\Fastcheckout\Notification
 */
class Interceptor extends \MultiSafepay\Connect\Controller\Fastcheckout\Notification implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Store\Model\StoreManagerInterface $storeManagerInterface, \Magento\CatalogInventory\Model\Spi\StockRegistryProviderInterface $stockRegistryProviderInterface, \Magento\Sales\Model\Order $order, \MultiSafepay\Connect\Helper\Data $data, \MultiSafepay\Connect\Model\Connect $connect, \MultiSafepay\Connect\Model\Fastcheckout $fastcheckout)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $invoiceSender, $storeManagerInterface, $stockRegistryProviderInterface, $order, $data, $connect, $fastcheckout);
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
