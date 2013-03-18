<?php
class Time {

	public static function deltaInWords($t1, $t2=null, $with_seconds=true){
		if (!$t2) $t2=time();
		return Time::inWords($t2-$t1, $with_seconds);
	}

	public static function inWords($delta_time, $with_seconds=true){
		$delta_seconds=floor(abs($delta_time));
        $delta_minutes=floor(abs($delta_time)/60);

        if($delta_minutes<=1){
            if(!$with_seconds){
                if ($delta_minutes==0){
                	return Yii::t('core', 'Less than a minute ago');
                }else{
                	return Yii::t('core', 'One minute ago');
                }
            }else{
                if($delta_seconds<=5){
                	return Yii::t('core', 'Just now');
                }elseif ($delta_seconds>=6 && $delta_seconds<=10){
                    return Yii::t('core', 'Less than 10 seconds ago');
                }elseif ($delta_seconds>=11 && $delta_seconds<=20){
                    return Yii::t('core', 'Less than 20 seconds ago');
                }elseif ($delta_seconds>=21 && $delta_seconds<=40){
                    return Yii::t('core', 'Half a minute ago');
                }elseif ($delta_seconds>=41 && $delta_seconds<=59){
                	return Yii::t('core', 'Less than a minute ago');
                }else{
                	return Yii::t('core', 'One minute ago');
                }
            }
        }elseif($delta_minutes==2){
        	return Yii::t('core', 'Two minutes ago');
        }elseif($delta_minutes<=10){
        	return Yii::t('core', '$delta_minutes minutes ago', array('$delta_minutes'=>$delta_minutes));
        }elseif($delta_minutes>10 && $delta_minutes<=44){
        	return Yii::t('core', '$delta_minutes minute ago', array('$delta_minutes'=>$delta_minutes));
        }elseif($delta_minutes>=45 && $delta_minutes<=89){
        	return Yii::t('core', 'One hour ago');
        }elseif($delta_minutes>=90 && $delta_minutes<=1439){
        	$hours=round($delta_minutes/60);
        	if($hours==2){
        		return Yii::t('core', 'Two hours ago');
        	}elseif($hours<=10){
        		return Yii::t('core', '$hours hours ago', array('$hours'=>$hours));
        	}else{
        		return Yii::t('core', '$hours hour ago', array('$hours'=>$hours));
        	}
        }elseif($delta_minutes>=1440 && $delta_minutes<=2879){
   			return Yii::t('core', 'One day ago');
   		}
   		elseif($delta_minutes>=2880 && $delta_minutes<=43199){
   			$days=round($delta_minutes/1440);
   			if($days==2){
   				return Yii::t('core', 'Two days ago');
   			}elseif($days<=10){
   				return Yii::t('core', '$days days ago', array('$days'=>$days));
   			}else{
   				return Yii::t('core', '$days day ago', array('$days'=>$days));
   			}
   		}elseif($delta_minutes>=43200 && $delta_minutes<=86399){
   			return Yii::t('core', 'One month ago');
   		}elseif($delta_minutes>=86400 && $delta_minutes<=525959){
   			$months=round($delta_minutes/43200);
   			if($months==2){
   				return Yii::t('core', 'Two months ago');
   			}elseif($months<=10){
   				return Yii::t('core', '$months months ago', array('$months'=>$months));
   			}else{
   				return Yii::t('core', '$months month ago', array('$months'=>$months));
   			}
   		}elseif($delta_minutes>=525960 && $delta_minutes<=1051919){
   			return Yii::t('core', 'About one year ago');
   		}else{
   			$years=floor($delta_minutes/525960);
   			if($years==2){
   				return Yii::t('core', 'Two years ago');
   			}elseif($years<=10){
   				return Yii::t('core', '$years years ago', array('$years'=>$years));
   			}else{
   				return Yii::t('core', '$years year ago', array('$years'=>$years));
   			}
   		}
   	}
}