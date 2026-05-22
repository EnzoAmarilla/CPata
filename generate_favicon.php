<?php

$src = 'public/images/logo-cpata-web.png';
$dest = 'public/favicon.png';

$image = imagecreatefrompng($src);
$width = imagesx($image);
$height = imagesy($image);

$newWidth = 128;
$newHeight = 128;

// Resize first
$resized = imagecreatetruecolor($newWidth, $newHeight);
imagealphablending($resized, false);
imagesavealpha($resized, true);
$transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

// Apply circular mask
$masked = imagecreatetruecolor($newWidth, $newHeight);
imagealphablending($masked, false);
imagesavealpha($masked, true);
$transparent = imagecolorallocatealpha($masked, 255, 255, 255, 127);
imagefilledrectangle($masked, 0, 0, $newWidth, $newHeight, $transparent);

for ($x = 0; $x < $newWidth; $x++) {
    for ($y = 0; $y < $newHeight; $y++) {
        // center coordinates
        $cx = $x - ($newWidth / 2);
        $cy = $y - ($newHeight / 2);
        
        $radius = min($newWidth, $newHeight) / 2;
        $distance = sqrt($cx * $cx + $cy * $cy);
        
        if ($distance <= $radius) {
            // inside circle, copy pixel
            $color = imagecolorat($resized, $x, $y);
            imagesetpixel($masked, $x, $y, $color);
        }
    }
}

imagepng($masked, $dest);
echo "Favicon generated at $dest\n";
