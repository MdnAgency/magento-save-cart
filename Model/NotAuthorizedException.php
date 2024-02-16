<?php
/**
 * NotAuthorizedException
 *
 * @copyright Copyright © 2024 Maison du Net. All rights reserved.
 * @author    vincent@maisondunet.com
 */

namespace Maisondunet\SaveQuote\Model;


use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;

class NotAuthorizedException extends LocalizedException
{

    public function __construct(?Phrase $phrase = null, \Exception $cause = null, $code = 0)
    {
        $phrase = $phrase ?? __("Not authorized");
        parent::__construct($phrase, $cause, $code);
    }

}
