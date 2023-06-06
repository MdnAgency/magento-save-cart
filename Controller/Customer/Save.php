<?php

namespace Maisondunet\SaveQuote\Controller\Customer;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Message\Manager;
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

    public function __construct(
        QuoteDescriptionInterfaceFactory $quoteDescriptionInterfaceFactory,
        SaveCommand                      $saveCommand,
        RequestInterface                 $request,
        ResultFactory                    $resultFactory,
        Manager                          $manager
    ) {
        $this->request = $request;
        $this->quoteDescriptionInterfaceFactory = $quoteDescriptionInterfaceFactory;
        $this->saveCommand = $saveCommand;
        $this->resultFactory = $resultFactory;
        $this->manager = $manager;
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
        $redirect->setUrl('https://app.test-magento.test/checkout/cart');
        return $redirect;
    }
}
