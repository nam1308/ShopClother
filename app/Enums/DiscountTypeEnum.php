<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class DiscountTypeEnum extends Enum
{
    const Type_1 =   1;
    const Type_2 =   2;
    // const Type_3 = 3;
    public static function getTypesOfDiscount($type)
    {
        if ($type == 1) {
            return 'Khuyến mại theo sản phẩm';
        } else return 'Khuyến mại gắn với tài khoản';
        // else if ($type == 3) return 'Khuyến mại theo loại';
        //else return 'Đã bị trả lại';
    }
}
