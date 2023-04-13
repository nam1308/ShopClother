<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class TypeShipEnum extends Enum
{
    const In =   1;
    const Out =   2;
    public function getType($type)
    {
        if ($type == 1) {
            return 'Nội Thành';
        } else return 'Ngoại Thành';
    }
}
