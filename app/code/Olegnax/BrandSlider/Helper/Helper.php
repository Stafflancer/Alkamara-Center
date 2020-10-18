<?php


namespace Olegnax\BrandSlider\Helper;

use Magento\Catalog\Model\Product\Attribute\Repository;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Olegnax\Core\Helper\Helper as CoreHelperHelper;

class Helper extends CoreHelperHelper
{
    const HIDE_PRODUCT_DEFAULT = true;
    const BRANDS_PATH_SMALL = 'wysiwyg/brands/small/';
    const BRANDS_PATH = 'wysiwyg/brands/';

    const CONFIG_MODULE = 'olegnax_brandslider';
    const XML_PATH_ATTRIBUTE_CODE = 'general/attribute_code';

    protected $repository;
    protected $_mediaDirectory;

    /**
     * @var  array|null
     */
    protected $items;
    /**
     * @var array
     */
    private $absolutePath;
    /**
     * @var Escaper
     */
    private $escaper;
    /**
     * @var Image
     */
    private $image;

    public function __construct(
        Context $context,
        Repository $repository,
        Escaper $escaper,
        Image $image,
        Filesystem $filesystem
    ) {
        $this->repository = $repository;
        $this->escaper = $escaper;
        $this->image = $image;
        $this->_mediaDirectory = $filesystem->getDirectoryRead(DirectoryList::MEDIA);
        parent::__construct($context);
    }

    public function getItems($itemsList = '')
    {
        if (!isset($this->items[$itemsList]) || empty($this->items[$itemsList])) {
            $this->items[$itemsList] = [];
            $attributeCode = $this->getAttribute();
            if ($attributeCode == '') {
                return $this->items;
            }

            $options = $this->repository->get($attributeCode)->getOptions();

            array_shift($options);
            $_itemsList = array_filter(array_map('trim', explode(',', $itemsList)));
            if(!empty($_itemsList)){
                foreach ($options as &$option) {
                    if(in_array($option->getLabel(), $_itemsList) ){
                        $option->setData('image_name', $this->getFileName($option->getLabel()));
                    }
                }
            } else {
                foreach ($options as &$option) {
                    $option->setData('image_name', $this->getFileName($option->getLabel()));
                }
            }
            $this->items[$itemsList] = $options;
        }

        return $this->items[$itemsList];
    }

    public function getAttribute()
    {
        return $this->getModuleConfig(self::XML_PATH_ATTRIBUTE_CODE);
    }

    public function getFileName($name, $path = self::BRANDS_PATH, $returnBool = false)
    {
        if (!is_array($this->absolutePath)) {
            $this->absolutePath = [];
        }
        if (!array_key_exists($path, $this->absolutePath)) {
            $this->absolutePath[$path] = $this->_mediaDirectory->getAbsolutePath($path);
        }
        $name = str_replace(
            [' ', '\'', '/', ':', '*', '?', '"', '<', '>', '|', '+', '.'],
            '_',
            strtolower($name)
        );
        $absolutePath = $this->absolutePath[$path];
        $paths = glob($absolutePath . $name . '.*');
        if (!empty($paths)) {
            $file_name = basename(array_shift($paths));
            return $path . $file_name;
        }
        if ($returnBool) {
            return false;
        }
        return $path . $name . '.png';
    }

    public function getProductBrandImage($product, $isBig = false, $size = [], $class = '')
    {
        $brand = $this->getAttribute();
        if (empty($brand))
            return '';
        $path = $isBig ? self::BRANDS_PATH : self::BRANDS_PATH_SMALL;
        $attribute = $product->getAttributeText($brand);
        if (is_array($attribute)) {
            $attribute = array_shift($attribute);
        }

        if ($attribute) {
            $fileName = $this->getFileName($attribute, $path, self::HIDE_PRODUCT_DEFAULT);
            if ($fileName) {
                $url = $this->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . $fileName;
                if (is_array($size)) {
                    $size = array_filter($size);
                }
                if (!empty($size)) {
                    $url = $this->image->adaptiveResize($fileName, $size)->getUrl();
                }
                return '<img
                    src="' . $this->escaper->escapeUrl($url) . '"
                    alt="' . $this->escaper->escapeHtmlAttr($attribute) . '"
                    class="ox-product-grid__brand-image ' . $this->escaper->escapeHtmlAttr($class) . '" />';
            }
        }
        return '';
    }

}
