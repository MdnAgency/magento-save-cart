<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\View\Result\PageFactory;

class View implements HttpGetActionInterface
{
    protected PageFactory $resultPageFactory;

    /**
     * @param PageFactory $resultPageFactory
     */
    public function __construct(PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute(): \Magento\Framework\View\Result\Page
    {
        return $this->resultPageFactory->create();
    }
}
