<?php
namespace App\Models\Temple\Repository;

use \App\Models\Temple\Entity\Temple as Temple;
use \App\Checker\TempleValidator as TempleValidator;
use DB;
use View;

class TempleRepository
{
    public static function update($id, $updateData)
    {
        Temple::where('id', '=', $id)->update($updateData);
    }

    public static function getCount($filter = 1)
    {
        return DB::table('temple')
                        ->select(DB::Raw('count(*) as count'))
                        ->leftJoin('user', 'temple.upid', '=', 'user.id')
                        ->whereRaw($filter)
                        ->get()[0]->count;
    }

    public static function getTempleDataById($id)
    {
        return DB::table('temple')
                ->leftJoin('user', 'temple.upid', '=', 'user.id')
                ->where('temple.id', '=', $id)
                ->select('temple.*','user.first_name', 'user.last_name')->first();
    }

    public static function getTempleBy($field, $val) 
    {
        return Temple::where($field, '=', $val)->get();
    }

    public static function getTempleList($authID, $filter, $limit, $page)
    {
        return DB::table('temple')
                    ->select('temple.*', 
                        DB::Raw("case when upid=".$authID." then 1 else 0 end as `show`"))
                    ->whereRaw($filter)
                    ->orderBy('id', 'desc')
                    ->skip(($page-1) * $limit)
                    ->take($limit)
                    ->get();
    }

    public static function getTempleForArea()
    {
        return DB::table('temple')
                    ->join('category', 'temple.area', '=', 'category.value')
                    ->select('area', 'word')
                    ->distinct()
                    ->get();
    }

    public static function getAllData()
    {
        return Temple::all()->toArray();
    }

    public static function getBookStore()
    {
        // return Temple::where('bookstore', '=' , 'true')->get();
        return Temple::where('area', '=' , 'center')->get();
    }
}