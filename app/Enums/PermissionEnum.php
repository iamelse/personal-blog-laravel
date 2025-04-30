<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case READ_DASHBOARD = 'dashboard_read';

    case UPDATE_HOME_HERO = 'home_hero_update';

    case UPDATE_HOME_ABOUT = 'home_about_update';

    case UPDATE_HOME_CTA = 'home_cta_update';

    case UPDATE_HOME_FOOTER = 'home_footer_update';

    case UPDATE_ABOUT = 'about_update';

    case UPDATE_RESUME = 'resume_update';

    case CREATE_SOCIAL_MEDIA = 'social_media_create';
    case READ_SOCIAL_MEDIA = 'social_media_read';
    case UPDATE_SOCIAL_MEDIA = 'social_media_update';
    case DELETE_SOCIAL_MEDIA = 'social_media_delete';

    case CREATE_QUICK_LINK = 'quick_link_create';
    case READ_QUICK_LINK = 'quick_link_read';
    case UPDATE_QUICK_LINK = 'quick_link_update';
    case DELETE_QUICK_LINK = 'quick_link_delete';

    case CREATE_SKILL = 'skills_create';
    case READ_SKILL = 'skills_read';
    case UPDATE_SKILL = 'skills_update';
    case DELETE_SKILL = 'skills_delete';

    case CREATE_USER = 'users_create';
    case READ_USER = 'users_read';
    case UPDATE_USER = 'users_update';
    case DELETE_USER = 'users_delete';

    case CREATE_ROLE = 'roles_create';
    case READ_ROLE = 'roles_read';
    case UPDATE_ROLE = 'roles_update';
    case DELETE_ROLE = 'roles_delete';
    case UPDATE_ROLE_PERMISSION = 'roles_update_permission';

    case CREATE_POST_CATEGORY = 'post_categories_create';
    case READ_POST_CATEGORY = 'post_categories_read';
    case UPDATE_POST_CATEGORY = 'post_categories_update';
    case DELETE_POST_CATEGORY = 'post_categories_delete';

    case CREATE_POST = 'posts_create';
    case READ_POST = 'posts_read';
    case UPDATE_POST = 'posts_update';
    case DELETE_POST = 'posts_delete';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
