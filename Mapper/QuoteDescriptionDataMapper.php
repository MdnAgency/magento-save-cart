<?php

namespace Maisondunet\SaveQuote\Mapper;

use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterfaceFactory;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModel;

/**
 * Converts a collection of QuoteDescription entities to an array of data transfer objects.
 */
class QuoteDescriptionDataMapper
{
    /**
     * @var QuoteDescriptionInterfaceFactory
     */
    private QuoteDescriptionInterfaceFactory $entityDtoFactory;

    /**
     * @param QuoteDescriptionInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        QuoteDescriptionInterfaceFactory $entityDtoFactory
    )
    {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|QuoteDescriptionInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var QuoteDescriptionModel $item */
        foreach ($collection->getItems() as $item) {
            /** @var QuoteDescriptionInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
