<?php

namespace Maisondunet\SaveQuote\Model\Data;

use Magento\Framework\DataObject;
use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

class QuoteDescriptionData extends DataObject implements QuoteDescriptionInterface
{
    /**
     * Getter for QuoteDescriptionId.
     *
     * @return int|null
     */
    public function getQuoteDescriptionId(): ?int
    {
        return $this->getData(self::QUOTE_DESCRIPTION_ID) === null ? null
            : (int)$this->getData(self::QUOTE_DESCRIPTION_ID);
    }

    /**
     * Setter for QuoteDescriptionId.
     *
     * @param int|null $quoteDescriptionId
     *
     * @return void
     */
    public function setQuoteDescriptionId(?int $quoteDescriptionId): void
    {
        $this->setData(self::QUOTE_DESCRIPTION_ID, $quoteDescriptionId);
    }

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Getter for Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Setter for Description.
     *
     * @param string|null $description
     *
     * @return void
     */
    public function setDescription(?string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
    }

    public function getQuoteId(): ?int
    {
        return $this->getData(self::QUOTE_ID);
    }

    public function setQuoteId(?int $quoteId): void
    {
        $this->setData(self::QUOTE_ID, $quoteId);
    }

    public function getCreatedAt(): ?string
    {
        return $this->getData(self::CREATED_AT);
    }
}
