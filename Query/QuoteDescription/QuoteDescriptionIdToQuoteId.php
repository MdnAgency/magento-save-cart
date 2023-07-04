<?php

namespace Maisondunet\SaveQuote\Query\QuoteDescription;

use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;

class QuoteDescriptionIdToQuoteId
{
    private QuoteDescriptionResource $quoteDescriptionResource;
    private QuoteDescriptionModelFactory $quoteDescriptionModelFactory;

    public function __construct(
        QuoteDescriptionResource     $quoteDescriptionResourceFactory,
        QuoteDescriptionModelFactory $quoteDescriptionModelFactory,
    ) {
        $this->quoteDescriptionResource = $quoteDescriptionResourceFactory;
        $this->quoteDescriptionModelFactory = $quoteDescriptionModelFactory;
    }

    public function execute(int $quoteDescriptionId)
    {
        $quoteDescription = $this->quoteDescriptionModelFactory->create();
        $this->quoteDescriptionResource->load($quoteDescription, $quoteDescriptionId);

        /** @var QuoteDescriptionInterface $quoteDescription */
        return $quoteDescription->getQuoteId();
    }
}
