<?php 

namespace App\Enums;

Class WorkTypesEnum
{
    const BOOK = 'Book';
    const COURSE = 'Course';
    const ARTICLE = 'Article';
    const BLOG = 'Blog';
    const OTHER = 'Other';

    public static function toArray() {
        return [
            self::BOOK => __(self::BOOK),
            self::COURSE => __(self::COURSE),
            self::ARTICLE => __(self::ARTICLE),
            self::BLOG => __(self::BLOG),
            self::OTHER => __(self::OTHER),
        ];
    }
}