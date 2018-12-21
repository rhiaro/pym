# Pym

Simple as possible image resizing proxy in PHP. Does just what I need right now and nothing more.

## Installation

1. Put on an Apache server.
2. Visit https://example.org/width/height/https://boop.lol/imageurl.jpg
3. Profit.

(Eg. `https://example.org/800/600/https://rhiaro.co.uk/photos/IMG_20181126_081617.jpg`)

* The `.htaccess` file rewrite base is a directory called `resize`. Change this if you put the code at `/` or in a different directory.
* Images are always resized in proportion.
* Maybe one day I'll add cropping.
* You can set width or height to `0` if you only care about the other.