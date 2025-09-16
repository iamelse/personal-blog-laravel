<?php

namespace App\Services;

use App\Enums\FileSystemDiskEnum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageManagementService
{
    protected ImageManager $imageManager;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
    }

    protected function publicUploadsPath($folder = '')
    {
        return '../public_html/' . $folder;
    }

    public function uploadImage(UploadedFile $file, array $options = [])
    {
        $currentImagePath = $options['currentImagePath'] ?? null;
        $disk = $options['disk'] ?? FileSystemDiskEnum::PUBLIC->value;
        $folder = $options['folder'] ?? null;
        $postTitle = $options['postTitle'] ?? null;
        $resize = $options['resize'] ?? ['width' => 800]; // default resize width 800

        // Baca env
        $shouldConvertToWebp = filter_var(env('APP_IMAGE_CONVERT_TO_WEBP', false), FILTER_VALIDATE_BOOLEAN);
        $shouldResize = filter_var(env('APP_IMAGE_RESIZE', false), FILTER_VALIDATE_BOOLEAN);

        // Generate file name tanpa ekstensi dulu
        $fileNameBase = $this->generateFileName($file, $postTitle);
        $extension = $shouldConvertToWebp ? 'webp' : $file->getClientOriginalExtension();
        $finalFileName = $fileNameBase . '.' . $extension;
        $path = ($folder ? "$folder/" : '') . $finalFileName;

        logger()->info("Uploading image. Disk: $disk, Folder: $folder, FileName: $finalFileName");

        // Hapus gambar lama jika ada
        if ($currentImagePath) {
            $this->destroyImage($currentImagePath, $disk);
        }

        // Baca gambar
        $image = $this->imageManager->read($file->getPathname());

        // Resize jika diaktifkan
        if ($shouldResize && !empty($resize) && isset($resize['width'])) {
            $image->scale(width: $resize['width']);
        }

        // Konversi ke webp jika diaktifkan
        if ($shouldConvertToWebp) {
            $encodedImage = $image->toWebp(quality: 80);
        } else {
            // Jika tidak konversi, encode sesuai format asli
            $encodedImage = $image->encode();
        }

        // Simpan
        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            Storage::disk('public')->put($path, $encodedImage);
            return $path;
        }

        if ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $directory = $this->publicUploadsPath($folder);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            file_put_contents($directory . '/' . $finalFileName, $encodedImage);
            return $folder . '/' . $finalFileName;
        }

        logger()->warning("No valid disk selected for image upload.");
        return null;
    }

    public function destroyImage($currentImagePath, $disk = FileSystemDiskEnum::PUBLIC->value): bool
    {
        logger()->info("Destroying image at: $currentImagePath using disk: $disk");

        if ($disk === FileSystemDiskEnum::PUBLIC->value) {
            if ($currentImagePath && Storage::disk('public')->exists($currentImagePath)) {
                Storage::disk('public')->delete($currentImagePath);
                logger()->info("Image deleted from 'public' disk: $currentImagePath");
                return true;
            }
        } elseif ($disk === FileSystemDiskEnum::IDCLOUDHOST->value) {
            $fullPath = $this->publicUploadsPath($currentImagePath);
            if ($currentImagePath && File::exists($fullPath)) {
                File::delete($fullPath);
                logger()->info("Image deleted from IDCLOUDHOST path: $fullPath");
                return true;
            } else {
                logger()->warning("File to delete does not exist: $fullPath");
            }
        }

        logger()->warning("Image not deleted. Path may be missing or disk invalid.");
        return false;
    }

    protected function generateFileName(UploadedFile $file, ?string $contextName = null): string
    {
        $name = $contextName
            ? Str::slug($contextName)
            : Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));

        return $name . '-' . time(); // tanpa ekstensi
    }
}
