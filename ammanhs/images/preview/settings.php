<?php

class Conf
{
	public static $qaulity=array('png'=>9, 'jpeg'=>85);
	public static $orig='..';
	public static $copy_to=false; // used to copy images to CDN
	public static $max_width=640;
	public static $max_height=480;
	public static $aspect_handling=2; // 0 stretch, 1 pad, 2 crop
	public static $bucketName='';

	public static $sizes=array(
		'16x16'=>true,
		'32x32'=>true,
		'64x64'=>true,
		'96x96'=>true,
		'128x128'=>true,
		'160x160'=>true,
		'256x256'=>true,
		'360x128'=>true, // activity thumbnail
		'900x320'=>true, // acitivty cover photo

		/*'480x480'=>array(
			array('watermark-corner.png', 1.0, 1.0), // file x-percent y-percent x-margin y-margin
			array('watermark-center.png', 0.5, 0.5),
			'watermark-tile.png', // tile
		)*/
	);
}