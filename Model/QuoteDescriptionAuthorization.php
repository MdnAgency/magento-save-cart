<?php
/**
 * QuoteDescriptionAuthorization
 *
 * @copyright Copyright © 2024 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\SaveQuote\Model;


use Magento\Quote\Model\QuoteRepository;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Api\QuoteDescriptionAuthorizationInterface;

class QuoteDescriptionAuthorization implements QuoteDescriptionAuthorizationInterface
{
    private \Magento\Customer\Model\Session $customerSession;
    private QuoteRepository $quoteRepository;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        QuoteRepository $quoteRepository,
    ) {
        $this->customerSession = $customerSession;
        $this->quoteRepository = $quoteRepository;
    }

    /**
     * @inheritDoc
     */
    public function canView(QuoteDescriptionInterface $quoteDescription): bool
    {
        $customerId = $this->customerSession->getCustomerId();
        $quoteId = $quoteDescription->getQuoteId();
        $quote = $this->quoteRepository->get($quoteId);
        return $quote->getCustomerId() == $customerId;
    }

    /**
     * @inheritDoc
     */
    public function canDelete(QuoteDescriptionInterface $quoteDescription): bool
    {
        return $this->canView($quoteDescription);
    }

    /**
     * @inheritDoc
     */
    public function canRestore(QuoteDescriptionInterface $quoteDescription): bool
    {
        return $this->canView($quoteDescription);
    }
}
