<?php

namespace App\Observers;

use App\Models\GalleryImage;
use Illuminate\Support\Facades\Storage;

class GalleryImageObserver
{
    public function saving(GalleryImage $image): void
    {
        if (!$image->isDirty('image_path') || !$image->image_path) return;

        $path = $image->image_path;
        if (strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'webp') return;

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) return;

        $srcPath  = $disk->path($path);
        $webpRel  = preg_replace('/\.[^.]+$/', '.webp', $path);
        $destPath = $disk->path($webpRel);

        if ($this->toWebP($srcPath, $destPath)) {
            $disk->delete($path);
            $image->image_path = $webpRel;
        }
    }

    private function toWebP(string $src, string $dest): bool
    {
        $info = @getimagesize($src);
        if (!$info) return false;

        $im = match ($info[2]) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($src),
            IMAGETYPE_PNG  => imagecreatefrompng($src),
            IMAGETYPE_GIF  => imagecreatefromgif($src),
            default        => null,
        };
        if (!$im) return false;

        if ($info[2] === IMAGETYPE_PNG) {
            imagepalettetotruecolor($im);
            imagealphablending($im, true);
            imagesavealpha($im, true);
        }

        $ok = imagewebp($im, $dest, 85);
        imagedestroy($im);
        return $ok;
    }
}
