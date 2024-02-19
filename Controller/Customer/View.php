<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Customer\Controller\AccountInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;
use Maisondunet\SaveQuote\Api\QuoteDescriptionAuthorizationInterface;
use Maisondunet\SaveQuote\Query\QuoteDescription\GetQuoteDescriptionInterface;
use Maisondunet\SaveQuote\ViewModel\CurrentQuote;

class View implements HttpGetActionInterface, AccountInterface
{
    protected PageFactory $resultPageFactory;
    private RequestInterface $request;
    private GetQuoteDescriptionInterface $getQuoteDescription;
    private QuoteDescriptionAuthorizationInterface $quoteDescriptionAuthorization;
    private RedirectFactory $redirectFactory;
    private UrlInterface $url;
    private CurrentQuote $currentQuote;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        RequestInterface $request,
        GetQuoteDescriptionInterface $getQuoteDescription,
        QuoteDescriptionAuthorizationInterface $quoteDescriptionAuthorization,
        PageFactory $resultPageFactory,
        UrlInterface $url,
        RedirectFactory $redirectFactory,
        CurrentQuote $currentQuote
    ){
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->getQuoteDescription = $getQuoteDescription;
        $this->quoteDescriptionAuthorization = $quoteDescriptionAuthorization;
        $this->redirectFactory = $redirectFactory;
        $this->url = $url;
        $this->currentQuote = $currentQuote;
    }

    public function execute()
    {
        $quoteDescriptionId = $this->request->getParam('id');
        $quoteDescription = $this->getQuoteDescription->execute($quoteDescriptionId);
        if($quoteDescription->getQuoteId() && $this->quoteDescriptionAuthorization->canView($quoteDescription)){
            $this->currentQuote->setQuote($quoteDescription);
            return $this->resultPageFactory->create();
        } else {
            $resultRedirect = $this->redirectFactory->create();
            return $resultRedirect->setUrl($this->url->getUrl('*/*'));
        }
    }
}
