<?php

namespace Maisondunet\SaveQuote\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * QuoteDescription entity search result.
 */
interface QuoteDescriptionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Set items.
     *
     * @param \Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface[] $items
     *
     * @return QuoteDescriptionSearchResultsInterface
     */
    public function setItems(array $items): QuoteDescriptionSearchResultsInterface;

    /**
     * Get items.
     *
     * @return \Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface[]
     */
    public function getItems(): array;
}
