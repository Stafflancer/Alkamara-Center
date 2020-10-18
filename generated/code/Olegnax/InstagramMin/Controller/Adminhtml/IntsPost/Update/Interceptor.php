<?php
namespace Olegnax\InstagramMin\Controller\Adminhtml\IntsPost\Update;

/**
 * Interceptor class for @see \Olegnax\InstagramMin\Controller\Adminhtml\IntsPost\Update
 */
class Interceptor extends \Olegnax\InstagramMin\Controller\Adminhtml\IntsPost\Update implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Olegnax\InstagramMin\Helper\Helper $helper, \Olegnax\InstagramMin\Helper\Image $imageHelper, \Psr\Log\LoggerInterface $logger, \Olegnax\InstagramMin\Model\IntsPost $model, \Magento\Framework\App\Filesystem\DirectoryList $directoryList, \Magento\Framework\Filesystem\Io\File $file, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $helper, $imageHelper, $logger, $model, $directoryList, $file, $resultPageFactory);
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
