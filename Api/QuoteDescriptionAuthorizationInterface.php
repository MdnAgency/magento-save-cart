<?php
/**
 * Created by Maisondunet.
 * @project     dexergie
 * @author      vincent
 * @copyright   2024 LA MAISON DU NET
 * @link        https://www.maisondunet.com
 */

namespace Maisondunet\SaveQuote\Api;

use Maisondunet\SaveQuote\Api\Data\QuoteDescriptionInterface;

interface QuoteDescriptionAuthorizationInterface
{

    /**
     * Check if saved cart can be viewed by user
     *
     * @param QuoteDescriptionInterface $quoteDescription
     * @return bool
     */
    public function canView(QuoteDescriptionInterface $quoteDescription): bool;

    /**
     * Check if saved cart can be deleted by user
     *
     * @param QuoteDescriptionInterface $quoteDescription
     * @return bool
     */
    public function canDelete(QuoteDescriptionInterface $quoteDescription): bool;

    /**
     * Check if saved cart can be restored (ie merged into current cart) by user
     *
     * @param QuoteDescriptionInterface $quoteDescription
     * @return bool
     */
    public function canRestore(QuoteDescriptionInterface $quoteDescription): bool;
}
