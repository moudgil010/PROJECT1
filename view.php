<?php
$file = urldecode($_GET['file']);

if (file_exists($file)) {
    $file_info = pathinfo($file);
    $file_extension = $file_info['extension'];

    switch ($file_extension) {
        case 'txt':
            $file_content = file_get_contents($file);
            echo "<pre>" . htmlspecialchars($file_content) . "</pre>";
            break;
        case 'jpeg':
        case 'jpg':
            header('Content-Type: image/jpeg');
            echo file_get_contents($file);
            break;
        case 'pdf':
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($file) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            @readfile($file);
            break;
        case 'png':
            header('Content-Type: image/png');
            echo file_get_contents($file);
            break;
        default:
            echo "File type not supported.";
            break;
    }
} else {
    echo "File not found.";
}
?>