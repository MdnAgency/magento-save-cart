<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Message\Manager;
use Magento\Framework\Url;
use Magento\Framework\Validation\ValidationException;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterfaceFactory;
use Maisondunet\SaveQuote\Command\QuoteDescription\SaveCommand;

class Save implements HttpPostActionInterface
{
    protected RequestInterface $request;
    private QuoteDescriptionInterfaceFactory $quoteDescriptionInterfaceFactory;
    private SaveCommand $saveCommand;
    private ResultFactory $resultFactory;
    private Manager $manager;
    private Url $url;

    public function __construct(
        QuoteDescriptionInterfaceFactory $quoteDescriptionInterfaceFactory,
        SaveCommand                      $saveCommand,
        RequestInterface                 $request,
        ResultFactory                    $resultFactory,
        Manager                          $manager,
        Url $url
    ) {
        $this->request = $request;
        $this->quoteDescriptionInterfaceFactory = $quoteDescriptionInterfaceFactory;
        $this->saveCommand = $saveCommand;
        $this->resultFactory = $resultFactory;
        $this->manager = $manager;
        $this->url = $url;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function execute()
    {
        $params = $this->request->getParams();
        $quoteDescription = $this->quoteDescriptionInterfaceFactory->create(["data" => $params]);
        try {
            $this->saveCommand->execute($quoteDescription);
        } catch (ValidationException $exception) {
            foreach ($exception->getErrors() as $error) {
                $this->manager->addErrorMessage($error->getMessage());
            }
        }

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $redirect->setUrl($this->url->getUrl('mdnsavecart/customer'));
        return $redirect;
    }
}
