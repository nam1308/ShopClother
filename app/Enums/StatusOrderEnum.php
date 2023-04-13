<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusOrderEnum extends Enum
{
    const Processing =   1;
    const Delivering =   2;
    const Delivered = 3;
    const Returned = 4;
    public static function getStatus($sta)
    {
        if ($sta == 1) {
            return 'Đang sử lý';
        } else if ($sta == 2) return 'Đang gửi';
        else if ($sta == 3) return 'Đã nhận';
        else return 'Đã bị trả lại';
    }
}
