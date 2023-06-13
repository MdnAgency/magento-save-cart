<?php

namespace Maisondunet\SaveQuote\ViewModel;

use Magento\Checkout\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Quote\Model\Quote;

class CurrentCart implements ArgumentInterface
{
    private ?Quote $quote;
    private Session $session;

    public function __construct(
        Session $session
    ) {
        $this->session = $session;
    }

    protected function getQuote(): ?Quote
    {
        if (!isset($this->quote)) {
            try {
                $this->quote = $this->session->getQuote();
            } catch (NoSuchEntityException|LocalizedException $e) {
                $this->quote = null;
            }
        }
        return $this->quote;
    }

    public function getActiveQuoteId(): ?int
    {
        $quote = $this->getQuote();
        if ($quote !== null) {
            return $quote->getId();
        } else {
            return null;
        }
    }
}
