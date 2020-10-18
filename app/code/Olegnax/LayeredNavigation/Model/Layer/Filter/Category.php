<?php
/**
 * @author      Olegnax
 * @package     Olegnax_LayeredNavigation
 * @copyright   Copyright (c) 2019 Olegnax (http://olegnax.com/). All rights reserved.
 * @license     Proprietary License https://olegnax.com/license/
 */

namespace Olegnax\LayeredNavigation\Model\Layer\Filter;


use Exception;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Layer;
use Magento\Catalog\Model\Layer\Filter\DataProvider\CategoryFactory;
use Magento\Catalog\Model\Layer\Filter\Item\DataBuilder;
use Magento\Catalog\Model\Layer\Filter\ItemFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\StateException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Search\Response\QueryResponse;
use Magento\Framework\Search\ResponseInterface;
use Magento\Search\Model\SearchEngine;
use Magento\Store\Model\StoreManagerInterface;
use Olegnax\LayeredNavigation\Helper\Helper;
use Olegnax\LayeredNavigation\Model\Layer\Filter;
use Olegnax\LayeredNavigation\Model\Request\Builder;
use Olegnax\LayeredNavigation\Model\ResourceModel\Fulltext\Collection;

class Category extends \Magento\CatalogSearch\Model\Layer\Filter\Category
{
    const FILTER_CODE = 'category';
    const ATTRIBUTE_CODE = 'category_ids';
    /**
     * @var Helper
     */
    protected $_helper;
    /**
     * @var array
     */
    protected $attributeValues;
    /**
     * @var mixed
     */
    protected $currentId;
    /**
     * @var ManagerInterface
     */
    protected $messageManager;
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;
    /**
     * @var SearchEngine
     */
    protected $searchEngine;
    /**
     * @var Filter
     */
    protected $layerFilter;
    /**
     * @var array
     */
    protected $categorys = [];
    /**
     * @var \Magento\Catalog\Model\Category
     */
    protected $category;
    /**
     * @var Layer\Filter\DataProvider\Category
     */
    private $dataProvider;
    /**
     * @var Escaper
     */
    private $escaper;

    /**
     * Category constructor.
     * @param ItemFactory $filterItemFactory
     * @param StoreManagerInterface $storeManager
     * @param Layer $layer
     * @param DataBuilder $itemDataBuilder
     * @param Escaper $escaper
     * @param CategoryFactory $categoryDataProviderFactory
     * @param Helper $helper
     * @param SearchEngine $searchEngine
     * @param ManagerInterface $messageManager
     * @param Filter $layerFilter
     * @param \Magento\Catalog\Model\Category $category
     * @param array $data
     * @throws LocalizedException
     */
    public function __construct(
        ItemFactory $filterItemFactory,
        StoreManagerInterface $storeManager,
        Layer $layer,
        DataBuilder $itemDataBuilder,
        Escaper $escaper,
        CategoryFactory $categoryDataProviderFactory,
        Helper $helper,
        SearchEngine $searchEngine,
        ManagerInterface $messageManager,
        Filter $layerFilter,
        \Magento\Catalog\Model\Category $category,
        array $data = []
    ) {
        parent::__construct(
            $filterItemFactory,
            $storeManager,
            $layer,
            $itemDataBuilder,
            $escaper,
            $categoryDataProviderFactory,
            $data
        );
        $this->_helper = $helper;
        $this->dataProvider = $categoryDataProviderFactory->create(['layer' => $this->getLayer()]);
        $this->searchEngine = $searchEngine;
        $this->messageManager = $messageManager;
        $this->escaper = $escaper;
        $this->layerFilter = $layerFilter;
        $this->category = $category;
    }

    /**
     * @param RequestInterface $request
     * @return $this|Category
     * @noinspection PhpDeprecationInspection
     */
    public function apply(RequestInterface $request)
    {
        if (!$this->pluginEnable()) {
            return parent::apply($request);
        }
        $this->currentId = $request->getParam('id');
        $categoryId = $request->getParam($this->_requestVar) ?: $this->currentId;
        if (empty($categoryId)) {
            return $this;
        }

        $categoryIds = explode(',', $categoryId);
        $categoryIds = array_unique($categoryIds);
        $this->setCurrentValue($categoryIds);

        /** @var Collection $productCollection */
        $productCollection = $this->getProductCollection();
        if ($this->isMultiselect() && count($categoryIds) >1) {
            $productCollection->addIndexCategoriesFilter(['in' => $categoryIds]);
            $category = $this->getLayer()->getCurrentCategory();
            $child = $category->getCollection()
                ->addFieldToFilter($category->getIdFieldName(), ['in' => $categoryIds])
                ->addAttributeToSelect('name');
            if ($this->shouldAddState()) {
                $this->addState($categoryIds, $child);
            }
        } else {
            $this->dataProvider->setCategoryId($categoryId);
            $productCollection->addCategoryFilter($this->dataProvider->getCategory());
            if ($this->shouldAddState()) {
                $this->addState();
            }
        }

        if (!$this->shouldVisible()) {
            $this->setItems([]); // set items to disable show filtering
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function pluginEnable()
    {
        return (bool)$this->_helper->isEnabled();
    }

    /**
     * @param array $attributeValues
     */
    protected function setCurrentValue(array $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    protected function getProductCollection()
    {
        return $this->getLayer()->getProductCollection();
    }

    /**
     * @return bool
     */
    protected function isMultiselect()
    {
        return true;
    }

    /**
     * @return bool
     */
    protected function shouldAddState()
    {
        return true;
    }

    /**
     * @param array $values
     * @param null $child
     */
    protected function addState($values = [], $child = null)
    {
        if ($child) {
            $labels = [];
            foreach ((array)$values as $value) {
                if ($currentCategory = $child->getItemById($value)) {
                    $labels[$currentCategory->getId()] = $currentCategory->getName();
                }
            }
            foreach ($labels as $id => $categoryName) {
                $state = $this->_createItem($categoryName, $id);
                $this->getLayer()->getState()->addFilter($state);
            }
        } else {
            $category = $this->dataProvider->getCategory();
            if ($this->currentId != $category->getId() && $this->dataProvider->isValid()) {
                $state = $this->_createItem($category->getName(), $category->getId());
                $this->getLayer()->getState()->addFilter($state);
            }
        }

    }

    /**
     * @return bool
     */
    protected function shouldVisible()
    {
        return true;
    }

    /**
     * @return array
     */
    public function _getItemsData()
    {
        if (!$this->pluginEnable()) {
            return parent::_getItemsData();
        }
        /** @var Collection $productCollection */
        $productCollection = $this->getProductCollection();

        $optionsFacetedData = $this->getOptionsFacetedData();
        $this->dataProvider->setCategoryId($this->currentId);
        $category = $this->dataProvider->getCategory();
        $categories = $category->getChildrenCategories();

        if ($category->getIsActive()) {
            foreach ($categories as $category) {
                $count = 0;
                if (isset($optionsFacetedData[$category->getId()])) {
                    $count = $optionsFacetedData[$category->getId()]['count'];
                }

                if ($category->getIsActive()) {
                    $this->itemDataBuilder->addItemData(
                        $this->escaper->escapeHtml($category->getName()),
                        $category->getId(),
                        $count
                    );
                }
            }
        }

        return $this->itemDataBuilder->build();
    }

    /**
     * @return array
     */
    protected function getOptionsFacetedData()
    {
        $optionsFacetedData = $this->generateOptionsFacetedData();

        return $optionsFacetedData;
    }

    /**
     * @return array
     * @noinspection PhpRedundantCatchClauseInspection
     */
    protected function generateOptionsFacetedData()
    {
        $productCollection = $this->getProductCollection();
        $attributeCode = static::FILTER_CODE;
        try {
            $optionsFacetedData = $productCollection->getFacetedData(
                $attributeCode,
                $this->getAlteredQueryResponse()
            );
        } catch (StateException $e) {
            if (!$this->messageManager->hasMessages()) {
                $this->messageManager->addErrorMessage(
                    __('Make sure that "%1" attribute can be used in layered navigation', $attributeCode)
                );
            }
            $optionsFacetedData = [];
        }

        return $optionsFacetedData;
    }

    /**
     * @return QueryResponse|ResponseInterface|null
     */
    protected function getAlteredQueryResponse()
    {
        $alteredQueryResponse = null;
        $categoryIds = $this->getCurrentValue();
        $categoryId = 0 < count($categoryIds) ? $categoryIds[0] : null;
        if ($this->hasCurrentValue() && $categoryId != $this->currentId) {
            try {
                $requestBuilder = $this->getRequestBuilder();
                $queryRequest = $requestBuilder->create();
                $alteredQueryResponse = $this->searchEngine->search($queryRequest);
            } catch (Exception $e) {
                $alteredQueryResponse = null;
            }
        }
        return $alteredQueryResponse;
    }

    /**
     * @return array
     */
    protected function getCurrentValue()
    {
        return $this->attributeValues;
    }

    /**
     * @return bool
     */
    protected function hasCurrentValue()
    {
        return !empty($this->attributeValues);
    }

    /**
     * @return Builder
     */
    protected function getRequestBuilder()
    {
        $requestBuilder = $this->getMemRequestBuilder();
        $attributeCode = static::ATTRIBUTE_CODE;
        $requestBuilder->removePlaceholder($attributeCode);
        $requestBuilder->setAggregationsOnly($attributeCode);

        return $requestBuilder;
    }

    /**
     * @return Builder
     */
    private function getMemRequestBuilder()
    {
        return clone $this->getProductCollection()->getMemRequestBuilder();
    }

    public function getIsDisableAjax($filterItem)
    {
        $categoryItem = $this->getCategoryItem($filterItem);
        return $categoryItem->getData('ox_nav_disable_ajax') || !$categoryItem->getIsAnchor();
    }

    /** @noinspection PhpDeprecationInspection */
    private function getCategoryItem($filterItem)
    {
        $value = $filterItem->getValue();
        if (!array_key_exists($value, $this->categorys)) {
            $category = clone $this->category;
            $this->categorys[$value] = $category->load($value);
        }

        return $this->categorys[$value];
    }

    public function getUrlItem($filterItem)
    {
        return $this->getCategoryItem($filterItem)->getUrl();
    }
}