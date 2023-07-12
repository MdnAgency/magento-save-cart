<?php

namespace Maisondunet\SaveQuote\Block\Button;


use Magento\Framework\View\Element\Template;
use Maisondunet\SaveQuote\Api\Button\ButtonActionInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class ButtonAction extends Template
{

    private ButtonActionInterface $buttonAction;
    private QuoteDescriptionInterface $quoteDescription;


    public function __construct(
        Template\Context $context,
        ButtonActionInterface $buttonAction,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->buttonAction = $buttonAction;
    }

    /**
     * @param QuoteDescriptionInterface $quoteDescription
     */
    public function setQuoteDescription(QuoteDescriptionInterface $quoteDescription): void
    {
        $this->quoteDescription = $quoteDescription;
    }

    public function createAction(): string
    {
        return $this->buttonAction->createAction($this->quoteDescription);
    }

    public function isPost(): bool {
        return $this->buttonAction->isPost();
    }

}
