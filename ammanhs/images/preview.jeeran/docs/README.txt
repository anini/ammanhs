php_img_preview
=================================

a web app to create thumbs or previews on the fly,
just deploy and the files on the server and it will work!

What license ?
=================================
This project is in public domain

Can we use it in a commercial closed source site ?
=================================
Yes

Where can I get it ?
=================================
the home page of the project is
  * http://git.ojuba.org/cgit/php_img_preview/

the latest file is 
  * http://git.ojuba.org/cgit/php_img_preview/snapshot/php_img_preview-master.tar.bz2

How does it work ?
=================================
the .htaccess re-write rules tells apache to serve the static
thumbnails/previews directly if they exists, elsewhere index.php will run
(passed the dimensions and original file) and it will generate the preview
file and serve it.

index.php does handle locks and if it will receive two requests for the same file
it will only work once and serve it for both.

Installation
=================================
copy settings.php.in into settings.php and set the allowed sizes

cp settings.php.in settings.php
vi settings.php

Make sure you have enabled .htaccess in your httpd config
you can do this by having the following line in apache config files:

AllowOverride All

How to use it ?
=================================
let's assume you have a folder with images called assets
and you have installed php_img_preview in it
and an image is accessible through:
 http://localhost/assets/linux/screenshot1.png
over the web, then a jpg preview of it can be accessed through
 http://localhost/assets/php_img_preview/32x32/linux/screenshot1.png.jpg

Why there are two extensions ?
=================================
think of it as a JPEG preview of the png image


How to remove stall previews ?
=================================
you don't have to keep previews of all images for ever
have a cron that removes preview files that were not accessed
in the past 7 days using the following command

cd path/to/php_img_preview/
find 32x32 64x64 -type f -atime +7 -delete

