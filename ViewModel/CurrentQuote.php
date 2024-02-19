<?php
/**
 * CurrentQuote
 *
 * @copyright Copyright © 2024 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\SaveQuote\ViewModel;


use Magento\Checkout\Model\Session;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Model\Quote;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class CurrentQuote implements ArgumentInterface
{

    private ?Quote $quote;
    private ?QuoteDescriptionInterface $quoteDescription;
    private CartRepositoryInterface $cartRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
    )
    {
        $this->quote = null;
        $this->cartRepository = $cartRepository;
    }

    public function getQuote(): ?Quote
    {
        return $this->quote;
    }

    public function getQuoteDescription(): ?QuoteDescriptionInterface
    {
        return $this->quoteDescription;
    }

    public function setQuote(QuoteDescriptionInterface $quoteDescription): void
    {
        /** @var Quote $quote */
        $quote = $this->cartRepository->get($quoteDescription->getQuoteId());
        $this->quote = $quote;
        $this->quoteDescription = $quoteDescription;
    }
}
