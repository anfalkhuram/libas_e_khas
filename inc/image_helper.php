<?php

function processAndSaveWebP($tmp_name, $target_path, $max_dim = 2000, $quality = 80) {
    if (!file_exists($tmp_name)) return false;
    
    $info = @getimagesize($tmp_name);
    if ($info === false) return false;
    
    $mime = $info['mime'];
    $img = null;
    
    switch ($mime) {
        case 'image/jpeg':
            $img = @imagecreatefromjpeg($tmp_name);
            break;
        case 'image/png':
            $img = @imagecreatefrompng($tmp_name);
            break;
        case 'image/webp':
            $img = @imagecreatefromwebp($tmp_name);
            break;
        default:
            return false; // Unsupported type
    }
    
    if (!$img) return false;
    
    $width = $info[0];
    $height = $info[1];
    
    if ($width > $max_dim || $height > $max_dim) {
        $ratio = $width / $height;
        if ($width > $height) {
            $new_w = (int)$max_dim;
            $new_h = (int)($max_dim / $ratio);
        } else {
            $new_h = (int)$max_dim;
            $new_w = (int)($max_dim * $ratio);
        }
        
        $new_img = imagecreatetruecolor($new_w, $new_h);
        
        if ($mime == 'image/png' || $mime == 'image/webp') {
            imagealphablending($new_img, false);
            imagesavealpha($new_img, true);
            $transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
            imagefilledrectangle($new_img, 0, 0, $new_w, $new_h, $transparent);
        }
        
        imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_w, $new_h, $width, $height);
        imagedestroy($img);
        $img = $new_img;
    } else {
        if ($mime == 'image/png') {
            imagealphablending($img, false);
            imagesavealpha($img, true);
        }
    }
    
    $result = imagewebp($img, $target_path, $quality);
    imagedestroy($img);
    return $result;
}
?>
