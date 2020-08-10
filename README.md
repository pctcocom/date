## Data
```
use Pctco\Date\Data;
```
```
Data::week(); // 周/星期
Data::zodiac(); // 生肖
Data::constellation(); // 星座
```

## Query
```
use Pctco\Date\Query;
```
```
// 根据出生日期计算年龄、生肖、星座
Query::attr('0000-00-00');
```
```
// 从日期中获取星期
Query::week(time());
```
```
// 倒计时
Query::countdown(time() + 86400);
```
```
// 发布文章等日期计算
Query::interval(time() - 86400);
```
```
// 获取向上或向下日期
Query::day(5,time(),'asc|desc','Y-m-d');
[
   1 => "2020-08-10"
   2 => "2020-08-11"
   3 => "2020-08-12"
   4 => "2020-08-13"
   5 => "2020-08-14"
]
```
```
// 17位时间戳
Query::time_17();
```
