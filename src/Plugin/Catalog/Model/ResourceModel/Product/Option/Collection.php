<?php

declare(strict_types=1);

namespace Infrangible\CatalogProductOptionInfo\Plugin\Catalog\Model\ResourceModel\Product\Option;

use Infrangible\CatalogProductOptionInfo\Helper\Data;
use Infrangible\Core\Helper\Stores;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2025 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class Collection
{
    /** @var Data */
    protected $helper;

    /** @var Stores */
    protected $storeHelper;

    public function __construct(Data $helper, Stores $storeHelper)
    {
        $this->helper = $helper;
        $this->storeHelper = $storeHelper;
    }

    public function beforeGetProductOptions(
        \Magento\Catalog\Model\ResourceModel\Product\Option\Collection $subject,
        $productId,
        $storeId,
        $requiredOnly = false
    ): array {
        $this->helper->addInfoToResult(
            $subject,
            $storeId
        );

        return [$productId, $storeId, $requiredOnly];
    }

    public function afterGetOptions(
        \Magento\Catalog\Model\ResourceModel\Product\Option\Collection $subject,
        \Magento\Catalog\Model\ResourceModel\Product\Option\Collection $result,
        $storeId
    ): \Magento\Catalog\Model\ResourceModel\Product\Option\Collection {
        $this->helper->addInfoToResult(
            $subject,
            $storeId
        );

        return $result;
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function beforeAddValuesToResult(
        \Magento\Catalog\Model\ResourceModel\Product\Option\Collection $subject,
        $storeId = null
    ): void {
        if ($storeId === null) {
            $storeId = $this->storeHelper->getStore()->getId();
        }

        $this->helper->addInfoToResult(
            $subject,
            $storeId
        );
    }
}
