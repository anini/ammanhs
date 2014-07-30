<?php

class Text
{
    public static function safeB64Encode($s){
        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($s));
    }

    public static function safeB64Decode($s){
        $pad=4 - (strlen($s) % 4);
        if ($pad==1) $s=$s."=";
        else if ($pad==2) $s=$s."==";
        else if ($pad==3) $s=$s."===";
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
    }

    public static function teaser($s, $l=256, $strip_tags=true, $fullwords=true){
    	$s  = $strip_tags ? strip_tags($s) : $s;
    	$s1 = str_replace(array("\n","\r"),array(" "," "), $s); // replace new line with spaces
    	$s2 = mb_substr($s1." ", 0, $l, "utf-8");
    	if($fullwords){
    		$i = strrpos($s2, " ");
    		if($i) $s2=substr($s2, 0, $i);
    	}else{
    		$s2=trim($s2);
    	}
    	if($s1 == $s2) return $s1;
    	return $s2."…"; // add ...
    }

    public static function truncate($text='', $length=100, $suffix='read more&hellip;', $isHTML=true){
    	$i = 0;
    	$tags = array();
    	if($isHTML){
    		preg_match_all('/<[^>]+>([^<]*)/', $text, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
    		foreach($m as $o){
    			if($o[0][1] - $i >= $length)
    				break;
    			$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);
    			if($t[0] != '/')
                    $tags[] = $t;
                elseif(end($tags) == substr($t, 1))
                    array_pop($tags);
                $i += $o[1][1] - $o[0][1];
            }
        }

        $output = substr($text, 0, $length = min(strlen($text),  $length + $i)) . (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '');

        // Get everything until last space
        $one = substr($output, 0, strrpos($output, " "));
        // Get the rest
        $two = substr($output, strrpos($output, " "), (strlen($output) - strrpos($output, " ")));
        // Extract all tags from the last bit
        preg_match_all('/<(.*?)>/s', $two, $tags);
        // Add suffix if needed
        if(strlen($text) > $length){
        	$one .= '&nbsp;' . $suffix;
        }else{
        	$one .= '&nbsp;read';
        }
        // Re-attach tags
        $output = $one . implode($tags[0]);

        return $output;
    }

    public static function truncateSharp($text, $limit){
    	if(strlen($text) > $limit){
    		$words = str_word_count($text, 2);
    		$pos = array_keys($words);
    		$text = substr($text, 0, $limit) . '...';
    	}
    	return $text;
    }

    public static function getTextBetweenTags($string, $tagname){
    	$matches=array();
    	$pattern = "/\<$tagname\>([^\<\>]*)\<\/$tagname\>/";
    	preg_match($pattern, $string, $matches);
    	return isset($matches[1])?$matches[1]:" ";
    }

    public static function autolink($text, $blank_target=true, $nofollow=true){
    	$pattern="/(((http[s]?:\/\/)|(www\.))(([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+(\.[a-z]{2,2})?)\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1})/is";
    	$text=preg_replace($pattern, " <a href='$1'>$1</a>", $text);
    	// Fix URLs without protocols
    	$text=preg_replace("/href='www/", "href='http://www", $text);
    	return $text;
    }

    public static function squezeWhitespaces($text, $single_line=false){
    	if($single_line){
    		$text = preg_replace('/\s+/', ' ', $text); // squeze all whitespaces into a single space
    	}else{
    		$text = preg_replace('/([ \t])+/', '\1', $text); // squeze spaces and tabs
    		$text = str_replace(array("\r\n", "\r"), array("\n", "\n"), $text); // dos2unix and mac2unix
    		$text = preg_replace('/\n{3,}/', "\n\n", $text); // squeze newlines
    	}
    	return trim($text);
    }

    public static function slugify($text){
    	$text = trim($text);
    	// replace non letter or digits by -
    	$text = str_replace(array(' & ', '&', "'", "`"), array(' and ', ' and ', '', ''), $text);
    	// sequeze spaces
    	$text = preg_replace('/\s+/', ' ', $text);
    	$text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    	// sequeze dashes
    	$text = preg_replace('/-{2,}/', '-', $text);
    	// transliterate
    	$text = iconv('utf-8', 'us-ascii//TRANSLIT//IGNORE', $text);
    	// lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // remove leading and tailing spaces
        // trim
        $text = trim($text, '-');
        $text = trim($text);
        return $text; // WARNING: might be empty
    }

    public static function isArabic($string){
    	if(preg_match('/\p{Arabic}/u', $string))
    		return true;
    	return false;
    }

    public static function getEmailDomain($em){
    	$ar = explode("@",$em);
    	return $ar[1];
    }

    public static function detectLanguage($text){
    	$a = array();
    	if (!preg_match("/\p{L}/u", html_entity_decode($text), $a) || sizeof($a) < 1) return Constants::LANG_UNSET;
    	$l = $a[0];
    	if(preg_match("/\p{Arabic}/u", $l)) return 'ar';
    	if(preg_match("/\p{Latin}/u", $l)) return 'en';
    	return 'unset';
    }

    public static function multiImplode($glue, $array){
    	$ret = '';
    	foreach($array as $item){
    		if(is_array($item)){
    			$ret .= self::multiImplode($glue, $item) . $glue;
    		}else{
    			$ret .= $item . $glue;
    		}
    	}
    	$ret = substr($ret, 0, 0-strlen($glue));
    	return $ret;
    }

    public static function addNofollowRelToAnchors($html, $only_externals=true){
        if($only_externals)
            return preg_replace('@(<a\s*(?!.*\brel=)[^>]*)(href="https?://)((?!ammanhs.com|www.ammanhs.com)[^"]+)"([^>]*)>@', '$1$2$3$4" rel="nofollow">', $html);
        else
            return preg_replace('|(<a\s*(?!.*\brel=)[^>]*)([^>]*)>|', '$1$2 rel="nofollow">', $html);
    }

    public static function addBlankTargetToAnchors($html){
        return preg_replace('|(<a\s*(?!.*\btarget=)[^>]*)([^>]*)>|', '$1$2 target="_blank">', $html);
    }

    public static function linkUrls($html, $blank_target=true, $nofollow=true){
        $pattern='@(?<!\'|"|/)(((((ht)|(f))tp[s]?://)|(www\.))([a-z][-a-z0-9]+\.)?([a-z][-a-z0-9]+\.)?[a-z][-a-z0-9]+\.[a-z]+[/]?[a-z0-9._\/~#&=;%+?-]*)@si';//(?!\'|")
        $replacement='<a href="$1"'.((($blank_target)?' target="_blank"':'').(($nofollow)?' rel="nofollow"':'')).'>$1</a>';
        $html=preg_replace($pattern, $replacement, $html);
        // Fix URLs without protocols
        $html=preg_replace('/href="www/', 'href="http://www', $html);
        return $html;
    }
    
    public static function embedYoutubeVideos($html, $responsive=true, $width="100%", $hight="100%"){
        $pattern='/(?<!\'|"|\/|\.)(((http(s)?:\/\/(www\.)?)|(www\.)|\b)(youtu\.be|youtube\.com)\/(embed\/|v\/|watch\/?(\?v=|\?(?!v=).+v=|\/))?(((?!#|\&|\?)[a-zA-Z0-9._-]+))([a-zA-Z0-9._\/~#&=;%+?-]*))/si';
        $replacement=($responsive?'<div class="yt-video">':'').'<iframe src="http://youtube.com/embed/$10?rel=0"'.(!$responsive?(' width="'.$width.'"'.' height="'.$height.'"'):'').'></iframe><a class="original-youtube-link" href="$1"></a>'.($responsive?'</div>':'');
        $html=preg_replace($pattern, $replacement, $html);
        return $html;
    }
}
