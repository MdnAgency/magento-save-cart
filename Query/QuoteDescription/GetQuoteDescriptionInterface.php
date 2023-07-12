<?php

namespace Maisondunet\SaveQuote\Query\QuoteDescription;

use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterfaceFactory;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Model\ResourceModel\QuoteDescriptionResource;

class GetQuoteDescriptionInterface
{
    private QuoteDescriptionResource $quoteDescriptionResourceFactory;
    private QuoteDescriptionModelFactory $quoteDescriptionModelFactory;
    private QuoteDescriptionInterfaceFactory $descriptionInterfaceFactory;


    public function __construct(
        QuoteDescriptionResource         $quoteDescriptionResourceFactory,
        QuoteDescriptionModelFactory     $quoteDescriptionModelFactory,
        QuoteDescriptionInterfaceFactory $descriptionInterfaceFactory,
    ) {
        $this->quoteDescriptionResourceFactory = $quoteDescriptionResourceFactory;
        $this->quoteDescriptionModelFactory = $quoteDescriptionModelFactory;
        $this->descriptionInterfaceFactory = $descriptionInterfaceFactory;
    }

    public function execute(int $id): QuoteDescriptionInterface
    {
        $quoteDescription = $this->quoteDescriptionModelFactory->create();
        $this->quoteDescriptionResourceFactory->load($quoteDescription, $id);

        $quoteDescriptionIface = $this->descriptionInterfaceFactory->create();
        $quoteDescriptionIface->addData($quoteDescription->getData());

        return $quoteDescriptionIface;
    }
}
