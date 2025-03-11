<?php

namespace App\Enums;

enum RoleEnum: string
{
    case MASTER = 'Master';
    case AUTHOR = 'Author';

    public function permissions(): array
    {
        return match ($this) {
            self::MASTER => [
                PermissionEnum::READ_DASHBOARD,

                PermissionEnum::UPDATE_HOME_HERO,

                PermissionEnum::CREATE_POST,
                PermissionEnum::READ_POST,
                PermissionEnum::UPDATE_POST,
                PermissionEnum::DELETE_POST,

                PermissionEnum::CREATE_USER,
                PermissionEnum::READ_USER,
                PermissionEnum::UPDATE_USER,
                PermissionEnum::DELETE_USER,
                
                PermissionEnum::CREATE_ROLE,
                PermissionEnum::READ_ROLE,
                PermissionEnum::UPDATE_ROLE,
                PermissionEnum::DELETE_ROLE,

                PermissionEnum::UPDATE_ROLE_PERMISSION
            ],
            self::AUTHOR => [
                PermissionEnum::READ_DASHBOARD,

                PermissionEnum::CREATE_POST,
                PermissionEnum::READ_POST,
                PermissionEnum::UPDATE_POST,
                PermissionEnum::DELETE_POST,
            ],
        };
    }
}