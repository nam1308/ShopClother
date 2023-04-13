<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PayMentEnum extends Enum
{
    const DirectCheck =   0;
    const BankTransfer =   1;
    const Paypal = 2;
}
