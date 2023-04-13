<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class OrderTypeEnum extends Enum
{
    const OrderSell =   1;
    const OrderImport =   2;
}
