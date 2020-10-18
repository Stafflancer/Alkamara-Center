<?php
namespace Olegnax\InstagramMin\Controller\Api\Oauth;

/**
 * Interceptor class for @see \Olegnax\InstagramMin\Controller\Api\Oauth
 */
class Interceptor extends \Olegnax\InstagramMin\Controller\Api\Oauth implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Psr\Log\LoggerInterface $logger, \Olegnax\InstagramMin\Helper\Helper $helper, \Magento\Framework\View\LayoutInterface $layout, \Olegnax\InstagramMin\Model\Client $client, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $logger, $helper, $layout, $client, $resultPageFactory);
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
