<?php

namespace Maisondunet\SaveQuote\Api\Data;

interface QuoteDescriptionInterface
{
    /**
     * String constants for property names
     */
    public const QUOTE_DESCRIPTION_ID = "entity_id";

    public const NAME = "name";
    public const DESCRIPTION = "description";
    public const QUOTE_ID ='quote_id';

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * Getter for Description.
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Setter for Description.
     *
     * @param string|null $description
     *
     * @return void
     */
    public function setDescription(?string $description): void;

    /**
     * Getter for quoteId
     * @return int|null
     */
    public function getQuoteId(): ?int;

    /**
     * Setter for quoteId
     * @param int|null $quoteId
     * @return void
     */
    public function setQuoteId(?int $quoteId): void;

    /**
     * Getter for quote description ID
     * @return int|null
     */
    public function getQuoteDescriptionId(): ?int;

}
