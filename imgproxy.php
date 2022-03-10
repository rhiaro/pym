<?
function check_img_url($url){
    $parts = explode("://", $url);
    if(count($parts) > 1){
        return $url;
    }else{
        // This is weird.
        // Sometimes one of the / in :// gets dropped
        // Probably goofing my regex in htaccess.
        $parts = explode(":/", $url);
        return implode("://", $parts);
    }
}

function check_mime($url){
    $imgsize = getimagesize($url);
    $mime = $imgsize["mime"];
    // var_dump($mime);
    if($mime=='image/jpeg'||$mime=='image/pjpeg'){
        return $url;
    }else{
        return "https://http.cat/418";
    }
}

function resize_image($file, $w, $h, $crop=FALSE) {
    $file = check_mime($file);
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
        if ($h > 0 && $w/$h > $r) {
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
    $img = check_img_url($_GET['img']);
    resize_image($img, $_GET['w'], $_GET['h']);
}
?>