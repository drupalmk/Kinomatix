<?php defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date {

   public static function print_date($timestamp, $text = '') {
       echo '<span class="date">'.$text.' '.self::locale_date("l j F, Y, H:i", $timestamp).'</span>';
   }
    
   public static function locale_date($format = "l j F, Y, H:i",$timestamp=null){
	$to_convert = array(
		'l'=>array('dat'=>'N','str'=>array('Poniedziałek','Wtorek','Środa','Czwartek','Piątek','Sobota','Niedziela')),
		'F'=>array('dat'=>'n','str'=> self::month_names_singular()),
		'f'=>array('dat'=>'n','str'=>array('stycznia','lutego','marca','kwietnia','maja','czerwca','lipca','sierpnia','września','października','listopada','grudnia'))
	);
	if ($pieces = preg_split('#[:/.\-, ]#', $format)){
		if ($timestamp === null) { $timestamp = time(); }
		foreach ($pieces as $datepart){
			if (array_key_exists($datepart,$to_convert)){
				$replace[] = $to_convert[$datepart]['str'][(date($to_convert[$datepart]['dat'],$timestamp)-1)];
			}else{
				$replace[] = date($datepart,$timestamp);
			}
		}
                $arr = array_combine($pieces, $replace);
                foreach($arr as $key => $val)
                {
                    if(empty($key))
                    {
                    $key = ' ';
                    }
                    if(empty($val))
                    {
                    $val = ' ';
                    }
                    $arr2[$key] = $val;
                }
                return strtr($format, $arr2);
	}
    }

    public static function month_names_singular() {
        return array(1 => 'Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec',
                        'Wrzesień', 'Październik', 'Listopad', 'Grudzień');
    }

    public static function days_as_numbers() {
        for($i = 1; $i < 32; $i++) {
            $days[$i] = $i;
        }
        return $days;
    }

    public static function years_from_now($next_years_count = 10) {
        $currentYear = (int) date('Y');
        $endYear = $currentYear + $next_years_count;
        for ($currentYear; $currentYear < $endYear; $currentYear++) {
            $years[$currentYear] = $currentYear;
        }
        return $years;
    }

}
