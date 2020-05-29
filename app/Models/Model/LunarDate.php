<?php
namespace App\Models\Model;

 class LunarDate
 {
 	public static function getLunarMonth() {
 		return array(
            '正月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','臘月',
            '閏正月','閏二月','閏三月','閏四月','閏五月','閏六月','閏七月','閏八月','閏九月','閏十月','閏十一月','閏臘月',
        );
 	}

    public static function getLunarDay() {
        return array(
            '初一','初二','初三','初四','初五','初六','初七','初八','初九','初十','十一','十二','十三','十四','十五',
            '十六','十七','十八','十九','廿十','廿一','廿二','廿三','廿四','廿五','廿六','廿七','廿八','廿九','三十',
        );
    }

    public static function getLunarHour() {
        return array(
            '子時','丑時','寅時','卯時','辰時','巳時','午時','未時','申時','酉時','戌時','亥時',
        );
    }
 }