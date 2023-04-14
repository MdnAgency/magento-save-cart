<?php

namespace Maisondunet\SaveQuote\Api;

use Magento\Framework\Exception\CouldNotDeleteException;

/**
 * Delete QuoteDescription by id Command.
 *
 * @api
 */
interface DeleteQuoteDescriptionByIdInterface
{
    /**
     * Delete QuoteDescription.
     * @param int $entityId
     * @return void
     * @throws CouldNotDeleteException
     */
    public function execute(int $entityId): void;
}
