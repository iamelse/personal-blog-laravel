<?php

use App\Enums\FileSystemDiskEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

if (!function_exists('getUserImageProfilePath')) {
    function getUserImageProfilePath($user)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $avatar = Avatar::create(Auth::user()->name);
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                return asset('storage/' . $user->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $user->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($user->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $avatar->toBase64();
    }
}

if (!function_exists('getAuthorPostImagePath')) {
    function getAuthorPostImagePath($user)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $avatar = Avatar::create($user->name ?? $user->full_name ?? 'User');
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                return asset('storage/' . $user->image);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $user->image;
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($user->image && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $avatar->toBase64();
    }
}

if (!function_exists('getAboutMeImageSection')) {
    function getAboutMeImageSection($content)
    {
        $disk = env('FILESYSTEM_DISK');
        $placeholderUrl = 'https://dummyimage.com/300';
        $appUrl = rtrim(env('APP_URL'), '/');
        $publicHtmlPath = base_path('../public_html');

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($content['image'] && Storage::disk('public')->exists($content['image'])) {
                return asset('storage/' . $content['image']);
            }
        }
        elseif ($disk === FileSystemDiskEnum::PUBLIC_UPLOADS->value) {
            $filePath = $content['image'];
            $fullPath = $publicHtmlPath . '/' . $filePath;
            if ($content['image'] && file_exists($fullPath)) {
                return $appUrl . '/' . $filePath;
            }
        }

        return $placeholderUrl;
    }
}
