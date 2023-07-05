<?php

namespace Maisondunet\SaveQuote\Plugin;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Sales\Model\ResourceModel\Collection\ExpiredQuotesCollection;
use Magento\Store\Api\Data\StoreInterface;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;

/**
 * We exclude quote saved by user from expired collection to avoid Garbage Collection on them
 */
class AfterExpiredQuotesCollection
{
    private QuoteDescriptionResource $quoteDescriptionResource;

    public function __construct(
        QuoteDescriptionResource $quoteDescriptionResource
    ) {
        $this->quoteDescriptionResource = $quoteDescriptionResource;
    }

    /**
     * @param ExpiredQuotesCollection $subject
     * @param AbstractCollection $expiredQuoteCollection
     * @param StoreInterface $store
     * @return AbstractCollection
     * @throws LocalizedException
     */
    public function afterGetExpiredQuotes(ExpiredQuotesCollection $subject, AbstractCollection $expiredQuoteCollection, StoreInterface $store): AbstractCollection
    {
        $expiredQuoteCollection->getSelect()->joinLeft(
            ['quote_description' => $this->quoteDescriptionResource->getMainTable()],
            'quote_description.quote_id = main_table.entity_id',
            []
        );
        $expiredQuoteCollection->addFieldToFilter(
            "quote_description.quote_id",
            ['null' => true]
        );

        return $expiredQuoteCollection;
    }
}
