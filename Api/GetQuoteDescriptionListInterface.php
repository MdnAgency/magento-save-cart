<?php

namespace Maisondunet\SaveQuote\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface;

/**
 * Get QuoteDescription list by search criteria query.
 *
 * @api
 */
interface GetQuoteDescriptionListInterface
{
    /**
     * Get QuoteDescription list by search criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface|null $searchCriteria
     * @return \Maisondunet\SaveQuote\Api\Data\QuoteDescriptionSearchResultsInterface
     */
    public function execute(?SearchCriteriaInterface $searchCriteria = null): QuoteDescriptionSearchResultsInterface;
}
