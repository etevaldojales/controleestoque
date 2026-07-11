<?php
// create_logo.php
// This script creates a simple logo image with the text "Jales Tecnologia" and saves it in the uploads directory

// Set the content type to PNG image (optional if just saving)
header('Content-Type: image/png');

// Image dimensions
$width = 400;
$height = 100;

// Create a blank image
$image = imagecreatetruecolor($width, $height);

// Colors
$background_color = imagecolorallocate($image, 255, 255, 255); // white background
$text_color = imagecolorallocate($image, 0, 102, 204); // blue text

// Fill the background
imagefilledrectangle($image, 0, 0, $width, $height, $background_color);

// Set the path to the font to use (use a built-in font or a TTF font if available)
$font_path = __DIR__ . '/arial.ttf'; // You may need to provide a TTF font file in the same directory

// Check if font file exists, else use built-in font
if (file_exists($font_path)) {
    // Add the text with TrueType font
    $font_size = 24;
    $angle = 0;
    $text = 'Jales Tecnologia';

    // Calculate text bounding box for centering
    $bbox = imagettfbbox($font_size, $angle, $font_path, $text);
    $text_width = $bbox[2] - $bbox[0];
    $text_height = $bbox[7] - $bbox[1];

    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2 - $bbox[7];

    imagettftext($image, $font_size, $angle, $x, $y, $text_color, $font_path, $text);
} else {
    // Use built-in font if TTF font not found
    $text = 'Jales Tecnologia';
    $font = 5; // built-in font size
    $text_width = imagefontwidth($font) * strlen($text);
    $text_height = imagefontheight($font);

    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;

    imagestring($image, $font, $x, $y, $text, $text_color);
}

// Save the image to the uploads directory
$upload_dir = __DIR__ . '/uploads';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}
$logo_path = $upload_dir . '/jales_tecnologia_logo.png';
imagepng($image, $logo_path);

// Free memory
imagedestroy($image);

// Output success message
echo "Logo created successfully at: uploads/jales_tecnologia_logo.png";

