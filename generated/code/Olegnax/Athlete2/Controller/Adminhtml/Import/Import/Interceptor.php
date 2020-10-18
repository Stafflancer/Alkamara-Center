<?php
namespace Olegnax\Athlete2\Controller\Adminhtml\Import\Import;

/**
 * Interceptor class for @see \Olegnax\Athlete2\Controller\Adminhtml\Import\Import
 */
class Interceptor extends \Olegnax\Athlete2\Controller\Adminhtml\Import\Import implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Xml\Parser $parser, \Olegnax\Athlete2\Model\DynamicStyle\Generator $generator)
    {
        $this->___init();
        parent::__construct($context, $filesystem, $parser, $generator);
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
