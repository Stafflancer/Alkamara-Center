<?php
namespace Olegnax\BannerSlider\Controller\Adminhtml\Slides\Save;

/**
 * Interceptor class for @see \Olegnax\BannerSlider\Controller\Adminhtml\Slides\Save
 */
class Interceptor extends \Olegnax\BannerSlider\Controller\Adminhtml\Slides\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Olegnax\BannerSlider\Helper\Image $helperImage)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $helperImage);
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
