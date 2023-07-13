<?php

namespace Maisondunet\SaveQuote\Model\Button;

use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class ButtonActionView implements \Maisondunet\SaveQuote\Api\Button\ButtonActionInterface
{
    private Url $url;
    private PostHelper $postHelper;

    public function __construct(
        Url $url,
        PostHelper $postHelper
    ) {
        $this->url = $url;
        $this->postHelper = $postHelper;
    }

    public function createAction(QuoteDescriptionInterface $quoteDescription): string
    {
        return $this->url->getUrl('mdnsavecart/customer/view', [ "id" => $quoteDescription->getQuoteDescriptionId()]);
    }

    public function isPost(): bool
    {
        return false;
    }
}
