<?php
class Time {

	public static function deltaInWords($t1, $t2=null, $with_seconds=true){
		if (!$t2) $t2=time();
		return Time::inWords($t2-$t1, $with_seconds);
	}

	public static function inWords($dt, $with_seconds=true){
		$delta_seconds = floor(abs($dt));
        $delta_minutes = floor(abs($dt) / 60);

        if ($delta_minutes <= 1){
            if (!$with_seconds){
                if ($delta_minutes == 0)
                    return 'Less than a minute ago';
                else
                    return 'One minute ago';
            }else{
                if ($delta_seconds <= 5)
                	return 'Just now';
                else if ($delta_seconds >= 6 && $delta_seconds <= 10){
                    return 'Less than 10 seconds ago';
                }
                else if ($delta_seconds >= 11 && $delta_seconds <= 20){
                    return 'Less than 20 seconds ago';
                }
                else if ($delta_seconds >= 21 && $delta_seconds <= 40){
                    return 'Half a minute ago';
                }
                else if ($delta_seconds >= 41 && $delta_seconds <= 59){
                	return 'Less than a minute ago';
                }
                else{
                	return 'One minute ago';
                }
            }
        }
        else if ($delta_minutes >= 2 && $delta_minutes <= 44){
        	return "{$delta_minutes} minutes ago";
        }
        else if ($delta_minutes >= 45 && $delta_minutes <= 89){
        	return "One hour ago";
        }
        else if ($delta_minutes >= 90 && $delta_minutes <= 1439){
        	$hours=round($delta_minutes / 60);
     		return "{$hours} hours ago";
     	}
   		else if ($delta_minutes >= 1440 && $delta_minutes <= 2879){
   			return "One day ago";
   		}
   		else if ($delta_minutes >= 2880 && $delta_minutes <= 43199){
   			$days=round($delta_minutes / 1440);
   			return "{$days} days ago";
   		}
   		else if ($delta_minutes >= 43200 && $delta_minutes <= 86399){
   			return "One month ago";
   		}
   		else if ($delta_minutes >= 86400 && $delta_minutes <= 525959){
   			$months=round($delta_minutes / 43200);
   			return "{$months} months ago";
   		}
   		else if ($delta_minutes >= 525960 && $delta_minutes <= 1051919){
   			return "About one year ago";
   		}
   		else{
   			$years=floor($delta_minutes / 525960);
   			return "More than {$years} years ago";
   		}
   	}
}