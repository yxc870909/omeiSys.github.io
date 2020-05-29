<?php
namespace App\Models\Category\Service;

use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;

class CategoryService
{
	public static function getHashTable($types = array())
    {
    	return CategoryRepository::getHashTable($types);
    }

    public static function getValueToWord($hash, $catType, $data)
    {
        return CategoryRepository::getValueToWord($hash, $catType, $data);
    }

    public static function getDataByType($type = '')
    {
    	return CategoryRepository::getDataByType($type);
    }

    public static function getDataByAttr($type = '')
    {
        return CategoryRepository::getDataByAttr($type);
    }

    public static function get_DDL($requestVal, $catType, $defaultText)
    {
        return CategoryRepository::get_DDL($requestVal, $catType, $defaultText);
    }

    public static function getBooksType_DDL($requestVal, $catType, $defaultText)
    {
        return CategoryRepository::getBooksType_DDL($requestVal, $catType, $defaultText);
    }

    public static function getAttr_DDL($type)
    {
        return CategoryRepository::getAttr_DDL($type);
    }

    public static function get_CheckBoxList($request = array(), $catType)
    {
        return CategoryRepository::get_CheckBoxList($request, $catType);
    }
}