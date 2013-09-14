<url>
	<loc><?php echo CHtml::encode($url); ?></loc>
	<?php
	if(isset($alt) && $alt){
		$alt=CHtml::encode($alt);
		echo "<xhtml:link rel=\"alternate\" hreflang=\"{$alt_lang}\" href=\"{$alt}\" />\n";
	}
	?>
	<changefreq>daily</changefreq>
	<priority>0.8</priority>
</url>