<?
function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return imagejpeg($dst);
}

if(!isset($_GET['img']) || !isset($_GET['h']) || !isset($_GET['w']) || !is_numeric($_GET['h']) || !is_numeric($_GET['h'])){
    header('HTTP/1.0 404 Not Found');
    echo 'HTTP/1.0 404 Not Found';
}else{
    header('Content-Type: image/jpeg');
    resize_image($_GET['img'], $_GET['w'], $_GET['h']);
}
?>