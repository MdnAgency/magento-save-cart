<?php

namespace Maisondunet\SaveQuote\Command\QuoteDescription;


use Magento\Framework\Validation\ValidationResult;
use Magento\Framework\Validation\ValidationResultFactory;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class QuoteDescriptionFormValidation
{
    private ValidationResultFactory $resultFactory;

    public function __construct(
        ValidationResultFactory $resultFactory
    ) {
        $this->resultFactory = $resultFactory;
    }
    public function validate(QuoteDescriptionInterface $quoteDescription): ValidationResult
    {
        $value = $quoteDescription->getName();
        if ('' === trim($value)) {
            $errors[] =__('"%field" can not be empty.', ['field' => QuoteDescriptionInterface::NAME]);
        } else {
            $errors = [];
        }

        return $this->resultFactory->create(['errors' => $errors]);
    }
}
