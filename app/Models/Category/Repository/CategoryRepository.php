<?php
namespace App\Models\Category\Repository;

use \App\Models\Category\Entity\Category as Category;

class CategoryRepository
{
	public static $types = array();
    private static $hashTableCache = array();

    public static function getHashTable($types = array())
    {
    	if ($types === '*') {
            $types = self::$types;
        }

        if (!is_array($types)) {
            return;
        }

        $true_types = array();
        $search_types = array();
        $l = count($types);

        while ($l--) {
            if (array_key_exists($types[$l], self::$hashTableCache)) {
                $true_types[$types[$l]] = self::$hashTableCache[$types[$l]];
                array_splice($types, $l, 1);
            }
        }
        
        $l = count($types);

        if (!$l) {
            return $true_types;
        }

        while ($l--) {
            if (!in_array($types[$l], self::$types)) {
                $search_types[$types[$l]] = array();
            }
        }
        
        if (!$search_types) {
            return $true_types();
        }

        //implode: 以,為間隔合併陣列中字串  array_key: 輸出陣列中的key        
        $res = Category::whereIn('type', array_keys($search_types) )->orderBy('id', 'ASC')->get();

        if (!$res) {
            return $true_types();
        }

        for ($i = 0, $j = count($res); $i < $j; ++$i) {
            $t = &$res[$i];
            $true_types[$t['type']][$t['value']] = array(
                'id' => $t['id'],
                'value' => $t['value'],
                'word' => $t['word'],
                'order' => $t['order'],
                'attribute' => $t['attribute'] ? json_decode($t['attribute'], true) : ''
            );
        }
        unset($t);

        self::$hashTableCache += $true_types;

       return $true_types;
    }

    public static function getValueToWord($hash, $catType, $data)
    {
        foreach($data as &$item) {
            if(isset($item[$catType]) && $item[$catType] != '')
                $item[$catType] = $hash[$catType][$item[$catType]]['word'];
            else
                $item[$catType] = '';
        }
        unset($item);

        return $data;
    }

    public static function getDataByType($type = '')
    {
    	return Category::where('type', '=', $type)->get();
    }

    public static function getDataByAttr($type = '')
    {
        return Category::where('type', '=', $type)->groupBy('attribute')->get();
    }

    public static function get_DDL($requestVal, $catType, $defaultText)
    {
        $data['data'] = CategoryRepository::getDataByType($catType);

        $data['word'] = '';
        foreach($data['data'] as &$d) { 
            if($requestVal == $d['value']) {
                $d['active'] = 'active';
                $data['word'] = $d['word'];
            }
            else
                $d['active'] = '';
        }
        unset($d);
        if($data['word'] == '') $data['word'] = $defaultText;
        return $data;
    }

    public static function getBooksType_DDL($requestVal, $catType, $defaultText)
    {
        $data['data'] = CategoryRepository::getDataByType($catType);
        $data['word'] = '';
        foreach($data['data'] as &$d) { 
            if($requestVal == substr($d['value'], 0 ,-3)) {
                $d['active'] = 'active';
                $data['word'] = $d['attribute'];
            }
            else
                $d['active'] = '';
        }
        unset($d);
        if($data['word'] == '') $data['word'] = $defaultText;
        return $data;
    }

    public static function getAttr_DDL($type)
    {
        $data['data'] = CategoryRepository::getDataByAttr($type);
        $data['word'] = '';
        foreach($data['data'] as &$d) { 
            if($type == $d['value']) {
                $d['active'] = 'active';
                $data['word'] = $d['word'];
            }
            else
                $d['active'] = '';

            if($type=='books_type')
                $d['value'] = substr($d['value'], 0, -3);
        }
        unset($d);
        if($data['word'] == '') $data['word'] = '選擇搜尋類別';
        return $data;
    }

    public static function get_CheckBoxList($request = array(), $catType)
    {
        $data = CategoryRepository::getDataByType($catType);
        foreach($request as $item) {
            foreach($data as &$d) {             
                if($item == $d['value'])
                    $d['checked'] = 'checked';
            }

            if(!isset($d['checked']))
                $d['checked'] = '';

            unset($d);
        }
        return $data;
    }
}