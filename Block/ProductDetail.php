<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Api\CartRepositoryInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Query\QuoteDescription\GetQuoteDescriptionInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;

class ProductDetail extends Template
{
    private RequestInterface $request;
    private CartRepositoryInterface $cartRepository;
    private QuoteDescriptionIdToQuoteId $quoteId;
    private GetQuoteDescriptionInterface $getQuoteDescription;


    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        CartRepositoryInterface $cartRepository,
        QuoteDescriptionIdToQuoteId $quoteId,
        GetQuoteDescriptionInterface $getQuoteDescription,

        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->request = $request;
        $this->cartRepository = $cartRepository;
        $this->quoteId = $quoteId;

        $this->getQuoteDescription = $getQuoteDescription;
    }

    /**
     * @return \Magento\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuote(): \Magento\Quote\Api\Data\CartInterface
    {
        $quoteDescriptionId = $this->request->getParam('id');
        return $this->cartRepository->get($this->quoteId->execute($quoteDescriptionId));
    }

    public function getQuoteDescription(): QuoteDescriptionInterface
    {
        return $this->getQuoteDescription->execute($this->request->getParam('id'));
    }
}
