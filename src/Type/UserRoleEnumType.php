<?php
namespace App\Type;

use App\Type\Enum\UserRoleEnum;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class UserRoleEnumType extends Type
{
    const ENUM_NAME = 'user_role_enum';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $values = implode(', ', array_map(function ($val) {
            return "'" . $val . "'";
        }, UserRoleEnum::toArray()));
        return "ENUM($values)";
    }

    public function getName()
    {
        return self::ENUM_NAME;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, UserRoleEnum::toArray())) {
            throw new \InvalidArgumentException("Invalid user role");
        }
        return $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!in_array($value, UserRoleEnum::toArray())) {
            throw new \InvalidArgumentException("Invalid user role");
        }
        return $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}