<?php
namespace Pctco\Date;
use Pctco\Date\Data;
/**
 * 查询
 */
class Query{
   public static function attr($date){
      //计算年龄
   	$birth = $date;
   	list($by,$bm,$bd) = explode('-',$birth);
   	$cm=date('n');
   	$cd=date('j');
   	$age=date('Y')-$by-1;
   	if ($cm>$bm || $cm==$bm && $cd>$bd) $age++;

   	$array['age'] = $age;

   	//计算生肖
   	$animals = Data::zodiac();
   	$key = ($by - 1900) % 12;
   	$array['animals'] = $animals[$key];

   	//计算星座
   	$constellation_name = Data::constellation();
   	if ($bd <= 22){
   		if ('1' !== $bm) $constellation = $constellation_name[$bm-2]; else $constellation = $constellation_name[11];
   	}else $constellation = $constellation_name[$bm-1];
   	$array['constellation'] = $constellation;

   	return $array;
   }
   public static function year(){
      $year = date('Y');
      if(($year%4 == 0 && $year%100 != 0) || ($year%400 == 0 )) { // 闰年
         return 366;
      }else { // 平年
         return 365;
      }
   }
   public static function week($time){
      $arr = explode("-",date('Y-m-d',$time));
      //参数赋值
      $year = $arr[0]; //年
      $month = sprintf('%02d',$arr[1]); //月，输出2位整型，不够2位右对齐
      $day = sprintf('%02d',$arr[2]); //日，输出2位整型，不够2位右对齐
      $hour = $minute = $second = 0; //时分秒默认赋值为0；
      //转换成时间戳
      $strap = mktime($hour,$minute,$second,$month,$day,$year);
      //获取数字型星期几
      $wk=date("w",$strap);
      //自定义星期数组
      $week = Data::week();
      //获取数字对应的星期
      return $week[$wk];
   }
   public static function countdown($stamp){
      $second = $stamp - time();
      $day = floor($second/(3600*24));
      $second = $second%(3600*24);//除去整天之后剩余的时间

      $hour = floor($second/3600);
      $second = $second%3600;//除去整小时之后剩余的时间

      $minute = floor($second/60);
      $second = $second%60;//除去整分钟之后剩余的时间
      //返回字符串
      $day = $day > 9 ? $day : '0'.$day;
      $hour = $hour > 9 ? $hour : '0'.$hour;
      $minute = $minute > 9 ? $minute : '0'.$minute;
      $second = $second > 9 ? $second : '0'.$second;
      return [$day,$hour,$minute,$second];
   }
   public static function interval($time,$depth,$format = 'Y-m-d'){
      $limit = time() - (int)$time;
      $r = "";

      if (is_array($depth)) {
         if($limit < 60) {
            $r = lang('Just published'); // Just published
         } elseif($limit >= 60 && $limit < 3600 && in_array('minutes',$depth)) { // 分钟前
            $r = floor($limit / 60) . lang('minutes ago');
         } elseif($limit >= 3600 && $limit < 86400 && in_array('hours',$depth)) { // 小时前
            $r = floor($limit / 3600) . lang('hours ago');
         } elseif($limit >= 86400 && $limit < 86400*7 && in_array('days',$depth)) { // 天前
            $r = floor($limit / 86400) . lang('days ago');
         } else {
            $r = date($format,$time);
         }
      }

      
      return $r;


      // elseif($limit >= 2592000 && $limit < 31104000 && in_array('months',$depth)) { // 个月前
      //    $r = floor($limit / 2592000) . lang('months ago');
      // }
   }
   public static function day($day,$time,$order = 'asc',$format = 'Y-m-d'){
      $week = $order == 'asc'?date('w', $time):$day;
      $date = [];
      for ($i=1; $i<=$day; $i++){
         $date[$i] = date($format ,strtotime( '+' . $i-$week .' days', $time));
      }
      return $date;
   }
   public static function specified($interval = 0,$start = '08:00:00',$end = '18:00:00'){
      $time = time();
      if ($interval < 0) $time = time() - 86400*$interval;
      if ($interval > 0) $time = time() + 86400*$interval;
      
      $date = date('Y-m-d',$time);
      $unix_start = strtotime($date.$start);
      $unix_end = strtotime($date.$end);

      $status = $unix_start <= $time && $unix_end >= $time;
      $interval_start = $unix_start - time();
      $interval_end = $unix_end - time();
      return [
         'status' => $status,
         'interval'  => [
            'time'   => $time,
            'start'  => $interval_start,
            'end' => $interval_end
         ],
         'unix'   => [
            'start'  => $unix_start,
            'end'  => $unix_end
         ]
      ];
   }
   public static function time_17(){
      list($usec, $sec) = explode(" ", microtime());
      $millisecond = round($usec*1000);
      $millisecond = str_pad($millisecond,3,'0',STR_PAD_RIGHT);
      return strval(date("YmdHis").$millisecond);
   }
   public static function time_13() { 
      list($t1, $t2) = explode(' ', microtime()); 
      return (int)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000); 
   }
}
