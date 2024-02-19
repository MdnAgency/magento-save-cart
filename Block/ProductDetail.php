<?php

namespace Maisondunet\SaveQuote\Block;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Template;
use Magento\Quote\Api\CartRepositoryInterface;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;
use Maisondunet\SaveQuote\Model\QuoteDescriptionModelFactory;
use Maisondunet\SaveQuote\Query\QuoteDescription\GetQuoteDescriptionInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\QuoteDescriptionIdToQuoteId;
use Maisondunet\SaveQuote\ViewModel\CurrentQuote;

class ProductDetail extends Template
{
    private RequestInterface $request;
    private CartRepositoryInterface $cartRepository;
    private QuoteDescriptionIdToQuoteId $quoteId;
    private GetQuoteDescriptionInterface $getQuoteDescription;
    private CurrentQuote $currentQuoteViewModel;


    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        CartRepositoryInterface $cartRepository,
        QuoteDescriptionIdToQuoteId $quoteId,
        GetQuoteDescriptionInterface $getQuoteDescription,
        CurrentQuote $currentQuoteViewModel,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->request = $request;
        $this->cartRepository = $cartRepository;
        $this->quoteId = $quoteId;

        $this->getQuoteDescription = $getQuoteDescription;
        $this->currentQuoteViewModel = $currentQuoteViewModel;
    }

    /**
     * @return \Magento\Quote\Api\Data\CartInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuote(): \Magento\Quote\Api\Data\CartInterface
    {
        $quote = $this->currentQuoteViewModel->getQuote();
        if($quote === null) {
            throw new \RuntimeException("ProductDetail block requires a CurrentQuote to be defined");
        }
        return $quote;
    }

    public function getQuoteDescription(): QuoteDescriptionInterface
    {
        return $this->getQuoteDescription->execute($this->request->getParam('id'));
    }
}
