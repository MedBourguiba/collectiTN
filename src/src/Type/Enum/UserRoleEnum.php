<?php
namespace App\Type\Enum;

class UserRoleEnum
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_CLIENT = 'ROLE_CLIENT';
    public const ROLE_PARTNER = 'ROLE_PARTNER';

    
    public static function toArray(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_CLIENT,
            self::ROLE_PARTNER,
        ];
    }
    public static function toArray2(): array
{
    return [
        self::ROLE_PARTNER,
    ];
}
    public  static function getAvailableRoles(): array
{
    return self::toArray();
}
}