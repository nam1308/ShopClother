<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class RoleEnum extends Enum
{
    const Customer =   'Người Dùng';
    const Manager =   'Nhân Viên';
    const Admin = 'Quản Lý';
    // public function getRole($role)
    // {
    //     if ($role == 1) {
    //         return 'Người Dùng';
    //     } else if ($role == 2) return 'Nhân Viên';
    //     else return 'Quản Lý';
    // }
}
