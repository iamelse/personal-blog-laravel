<?php

use App\Enums\FileSystemDiskEnum;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Avatar;

/**
 * Helper dasar: cek file di storage/public_html, return URL kalau ada.
 * Jika file tidak ada -> return null.
 */
if (!function_exists('getFileUrl')) {
    function getFileUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $disk = env('FILESYSTEM_DISK');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value && Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        if ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $fullPath = $publicHtmlPath . '/' . $path;
            if (file_exists($fullPath)) {
                return $appUrl . '/' . $path;
            }
        }

        return null;
    }
}

/**
 * Image helper: return URL file atau placeholder jika tidak ada.
 */
if (!function_exists('getImageUrl')) {
    function getImageUrl(?string $path, string $placeholderUrl): string
    {
        return getFileUrl($path) ?? $placeholderUrl;
    }
}

/**
 * Avatar helper: return URL file atau generate avatar (base64).
 */
if (!function_exists('getAvatarUrl')) {
    function getAvatarUrl(?string $path, string $name): string
    {
        $avatar = new Avatar();
        $avatar = $avatar->create($name);
        return getFileUrl($path) ?? $avatar->toBase64();
    }
}

/**
 * IMPLEMENTASI UNTUK KASUS SEKARANG
 */

if (!function_exists('getUserImageProfilePath')) {
    function getUserImageProfilePath($user): string
    {
        return getAvatarUrl($user->image ?? null, $user->name ?? 'User');
    }
}

if (!function_exists('getAuthorPostImagePath')) {
    function getAuthorPostImagePath($user): string
    {
        return getAvatarUrl($user->image ?? null, $user->name ?? $user->full_name ?? 'User');
    }
}

if (!function_exists('getAboutMeImageSection')) {
    function getAboutMeImageSection(array $content): string
    {
        return getImageUrl($content['image'] ?? null, 'https://dummyimage.com/300');
    }
}

if (!function_exists('getPostCover')) {
    function getPostCover($post): string
    {
        return getImageUrl($post->cover ?? null, 'https://dummyimage.com/600x400/cccccc/000000&text=No+Cover');
    }
}
