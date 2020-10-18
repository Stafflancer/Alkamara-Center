<?php
namespace Magefan\Translation\Controller\Adminhtml\Translation\Edit;

/**
 * Interceptor class for @see \Magefan\Translation\Controller\Adminhtml\Translation\Edit
 */
class Interceptor extends \Magefan\Translation\Controller\Adminhtml\Translation\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Registry $registry, \Magefan\Translation\Api\TranslationRepositoryInterface $translationRepository)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $registry, $translationRepository);
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
