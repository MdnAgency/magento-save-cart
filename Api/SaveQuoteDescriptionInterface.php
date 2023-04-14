<?php

namespace Maisondunet\SaveQuote\Api;

use Magento\Framework\Exception\CouldNotSaveException;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

/**
 * Save QuoteDescription Command.
 *
 * @api
 */
interface SaveQuoteDescriptionInterface
{
    /**
     * Save QuoteDescription.
     * @param \Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface $quoteDescription
     * @return int
     * @throws CouldNotSaveException
     */
    public function execute(QuoteDescriptionInterface $quoteDescription): int;
}
