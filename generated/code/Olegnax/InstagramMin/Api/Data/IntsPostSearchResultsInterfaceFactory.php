<?php
namespace Olegnax\InstagramMin\Api\Data;

/**
 * Factory class for @see \Olegnax\InstagramMin\Api\Data\IntsPostSearchResultsInterface
 */
class IntsPostSearchResultsInterfaceFactory
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Instance name to create
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Olegnax\\InstagramMin\\Api\\Data\\IntsPostSearchResultsInterface')
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
    }

    /**
     * Create class instance with specified parameters
     *
     * @param array $data
     * @return \Olegnax\InstagramMin\Api\Data\IntsPostSearchResultsInterface
     */
    public function create(array $data = [])
    {
        return $this->_objectManager->create($this->_instanceName, $data);
    }
}
