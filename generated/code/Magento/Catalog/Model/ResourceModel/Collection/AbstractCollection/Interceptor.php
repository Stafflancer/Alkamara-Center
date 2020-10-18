<?php
namespace Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection;

/**
 * Interceptor class for @see \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection
 */
class Interceptor extends \Magento\Catalog\Model\ResourceModel\Collection\AbstractCollection implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactory $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Eav\Model\Config $eavConfig, \Magento\Framework\App\ResourceConnection $resource, \Magento\Eav\Model\EntityFactory $eavEntityFactory, \Magento\Eav\Model\ResourceModel\Helper $resourceHelper, \Magento\Framework\Validator\UniversalFactory $universalFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, ?\Magento\Framework\DB\Adapter\AdapterInterface $connection = null)
    {
        $this->___init();
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $eavConfig, $resource, $eavEntityFactory, $resourceHelper, $universalFactory, $storeManager, $connection);
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(\Magento\Framework\DataObject $object)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addItem');
        if (!$pluginInfo) {
            return parent::addItem($object);
        } else {
            return $this->___callPlugins('addItem', func_get_args(), $pluginInfo);
        }
    }
}
