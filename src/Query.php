<?php
namespace Pctco\Color;
use Data;
/**
 * 查询
 */
class Query{
   /**
   * @name attr
   * @describe 根据出生日期计算年龄、生肖、星座
   * @param mixed $date = "0000-00-00" 日期
   * @return Array
   **/
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
   	$animals = ['鼠', '牛', '虎', '兔', '龙', '蛇','马', '羊', '猴', '鸡', '狗', '猪'];
   	$key = ($by - 1900) % 12;
   	$array['animals'] = $animals[$key];

   	//计算星座
   	$constellation_name = ['水瓶座','双鱼座','白羊座','金牛座','双子座','巨蟹座','狮子座','处女座','天秤座','天蝎座)','射手座','摩羯座'];
   	if ($bd <= 22){
   		if ('1' !== $bm) $constellation = $constellation_name[$bm-2]; else $constellation = $constellation_name[11];
   	}else $constellation = $constellation_name[$bm-1];
   	$array['constellation'] = $constellation;

   	return $array;
   }
   /**
   * @name week
   * @describe 从日期中获取星期
   * @param mixed $date 日期 0000-00-00
   * @return
   **/
   public static function week($date){
      $conversionDate = date('Y-m-d',strtotime($date)); //强制转换日期格式
      $arr = explode("-", $conversionDate); //封装成数组
      //参数赋值
      $year = $arr[0]; //年
      $month = sprintf('%02d',$arr[1]); //月，输出2位整型，不够2位右对齐
      $day = sprintf('%02d',$arr[2]); //日，输出2位整型，不够2位右对齐
      $hour = $minute = $second = 0; //时分秒默认赋值为0；
      //转换成时间戳
      $strap = mktime($hour,$minute,$second,$month,$day,$year);
      //获取数字型星期几
      $number_wk=date("w",$strap);
      //自定义星期数组
      $week = Data::week();
      //获取数字对应的星期
      return $week[$number_wk];
   }
}
