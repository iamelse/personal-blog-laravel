<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case READ_DASHBOARD = 'dashboard_read';
    
    case UPDATE_HOME_HERO = 'home_hero_update';

    case CREATE_SKILL = 'skills_create';
    case READ_SKILL = 'skills_read';
    case UPDATE_SKILL = 'skills_update';
    case DELETE_SKILL = 'skills_delete';

    case CREATE_POST = 'posts_create';
    case READ_POST = 'posts_read';
    case UPDATE_POST = 'posts_update';
    case DELETE_POST = 'posts_delete';

    case CREATE_USER = 'users_create';
    case READ_USER = 'users_read';
    case UPDATE_USER = 'users_update';
    case DELETE_USER = 'users_delete';

    case CREATE_ROLE = 'roles_create';
    case READ_ROLE = 'roles_read';
    case UPDATE_ROLE = 'roles_update';
    case DELETE_ROLE = 'roles_delete';
    case UPDATE_ROLE_PERMISSION = 'roles_update_permission';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}