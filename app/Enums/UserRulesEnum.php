<?php 

namespace App\Enums;

Class UserRulesEnum
{
    const User = 1;


    public static function toArray() {
        return [
            self::User => __('User'),
        ];
    }
}