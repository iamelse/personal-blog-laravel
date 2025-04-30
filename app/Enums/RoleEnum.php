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
                PermissionEnum::UPDATE_HOME_ABOUT,
                PermissionEnum::UPDATE_HOME_CTA,
                PermissionEnum::UPDATE_HOME_FOOTER,

                PermissionEnum::UPDATE_ABOUT,

                PermissionEnum::UPDATE_RESUME,

                PermissionEnum::CREATE_SOCIAL_MEDIA,
                PermissionEnum::READ_SOCIAL_MEDIA,
                PermissionEnum::UPDATE_SOCIAL_MEDIA,
                PermissionEnum::DELETE_SOCIAL_MEDIA,

                PermissionEnum::CREATE_QUICK_LINK,
                PermissionEnum::READ_QUICK_LINK,
                PermissionEnum::UPDATE_QUICK_LINK,
                PermissionEnum::DELETE_QUICK_LINK,

                PermissionEnum::CREATE_SKILL,
                PermissionEnum::READ_SKILL,
                PermissionEnum::UPDATE_SKILL,
                PermissionEnum::DELETE_SKILL,

                PermissionEnum::CREATE_USER,
                PermissionEnum::READ_USER,
                PermissionEnum::UPDATE_USER,
                PermissionEnum::DELETE_USER,

                PermissionEnum::CREATE_ROLE,
                PermissionEnum::READ_ROLE,
                PermissionEnum::UPDATE_ROLE,
                PermissionEnum::DELETE_ROLE,

                PermissionEnum::UPDATE_ROLE_PERMISSION,

                PermissionEnum::CREATE_POST_CATEGORY,
                PermissionEnum::READ_POST_CATEGORY,
                PermissionEnum::UPDATE_POST_CATEGORY,
                PermissionEnum::DELETE_POST_CATEGORY,

                PermissionEnum::CREATE_POST,
                PermissionEnum::READ_POST,
                PermissionEnum::UPDATE_POST,
                PermissionEnum::DELETE_POST,
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
