<?php

namespace Maisondunet\SaveQuote\Model;

use Magento\Framework\Api\SearchResults;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface;

/**
 * QuoteDescription entity search results implementation.
 */
class QuoteDescriptionSearchResults extends SearchResults implements QuoteDescriptionSearchResultsInterface
{
    /**
     * Set items list.
     *
     * @param array $items
     *
     * @return QuoteDescriptionSearchResultsInterface
     */
    public function setItems(array $items): QuoteDescriptionSearchResultsInterface
    {
        return parent::setItems($items);
    }

    /**
     * Get items list.
     *
     * @return array
     */
    public function getItems(): array
    {
        return parent::getItems();
    }
}
