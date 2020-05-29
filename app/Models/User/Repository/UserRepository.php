<?php
namespace App\Models\User\Repository;

use \App\Models\User\Entity\User as User;
use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;
use \App\Models\Group\Repository\GroupRepository as GroupRepository;
use Auth;
use DB;

class UserRepository
{
    public static function getValidatorEvent()
    {
        $event = array(
            'AddTemple'=>array('admin','editor','local'),
            'EditTemple'=>array('admin','editor','local'),
            'AddUser_AddTab'=>array('admin','editor'),
            'GroupTab'=>array('admin','editor'),
            'EditPersonnel'=>array('admin','editor','local'),
            'EditPersonnel_Auth'=>array('admin'),
            'Agenda_AddTab'=>array('admin','editor'),
            'AddActivity_Record'=>array('admin','editor'),
            'AddCenter_Record'=>array('admin','editor'),
            'AddCenter_Status'=>array('admin','editor'),
            'MenuClasmanag'=>array('admin','editor'),
            'AddBookBorrow'=>array('admin','editor'),
            'AddBookBorrowCount'=>array('admin','editor'),
            'EditBookBorrow'=>array('admin','editor'),
            'BookBorrow_RecordTab'=>array('admin','editor'),
            'BookBorrow_BorrowTab'=>array('admin','editor'),
            'AddBookBorrow_itemShow'=>array('admin','editor'),
            'IsBorrow_Show'=>array('admin','editor'),
            );

        return $event;
    }

    public static function UserTypeValidator($eventName, $userType)
    {
        $validator = false;
        $event = UserRepository::getValidatorEvent();
        foreach($event as $key => $val) {
            if($key == $eventName) {
                foreach($val as $item) {
                    if($item == $userType)
                        $validator = true;
                }
            }
        }

        return $validator;
    }

    public static function update($id, $updateData)
    {
        User::where('id', '=', $id)->update($updateData);
    }

    public static function getPageCount($filter = 1, $upids = array())
    {
        if(count($upids) > 0)
            return DB::table('user as a')
                        ->leftJoin('groups as g', 'a.id', '=', 'g.upid')
                        ->leftJoin('user as b', 'a.Dianchuanshi', '=', 'b.id')
                        ->whereIn('a.id', $upids)
                        ->whereRaw($filter)
                        ->select(DB::Raw('count(*) as count'))
                        ->get()[0]->count;
        else
            return DB::table('user as a')
                        ->leftJoin('groups as g', 'a.id', '=', 'g.upid')
                        ->leftJoin('user as b', 'a.Dianchuanshi', '=', 'b.id')
                        ->whereRaw($filter)
                        ->select(DB::Raw('count(*) as count'))
                        ->get()[0]->count;
    }

    public static function getUserAndMainFamliy($upid)
    {
        $res = DB::table('user as u')
                    ->leftJoin('regist as r', 'u.regist_id', '=', 'r.id')
                    ->leftJoin('temple as t', 'r.tid', '=', 't.id')
                    ->leftJoin('user as u1', 'u.Dianchuanshi', '=', 'u1.id')
                    ->leftJoin('user as u2', 'u.Introducer', '=', 'u2.id')
                    ->leftJoin('user as u3', 'u.Guarantor', '=', 'u3.id')
                    ->leftJoin('user as u4', 'u.father', '=', 'u4.id')
                    ->leftJoin('user as u5', 'u.mother', '=', 'u5.id')
                    ->leftJoin('user as u6', 'u.spouse', '=', 'u6.id')
                    ->where('u.id', '=', $upid)
                    ->select('u.*',
                             't.name',
                             DB::Raw('concat(u1.first_name, u1.last_name) as Dianchuanshi'),
                             DB::Raw('concat(u2.first_name, u2.last_name) as Introducer'),
                             DB::Raw('concat(u3.first_name, u3.last_name) as Guarantor'),
                             DB::Raw('concat(u4.first_name, u4.last_name) as father'),
                             DB::Raw('concat(u5.first_name, u5.last_name) as mother'),
                             DB::Raw('concat(u6.first_name, u6.last_name) as spouse'),
                             'u.father as father_id',
                             'u.mother as mother_id',
                             'u.spouse as spouse_id')
                    ->get()[0];

        $res = json_decode(json_encode($res), true);

        $hash = CategoryRepository::getHashTable(array('group','group_type','work', 'position', 'edu', 'skill'));

        $brosis = json_decode($res['brosis']);
        $child = json_decode($res['child']);
        $relative = json_decode($res['relative']);

        $ids = array();
        if(is_array($brosis))
            $ids = array_merge($brosis, $child);
        if(is_array($relative))
            $ids = array_merge($ids, $relative);

        $result = UserRepository::getUsersByUpid(0, '1', $ids, 30, 1);
        $result = json_decode(json_encode($result), true);
        
        $tmp1 = $brosis;
        $tmp2 = $child;
        $tmp3 = $relative;
        $tmp4 = $res['position']!='' ? json_decode($res['position']) : array();
        $brosis = array();
        $child = array();
        $relative = array();
        foreach($result as $item) {

            $i = 0;
            foreach($tmp1 as $id) {
                if($item['id'] == $id){
                    $brosis[$i]['word'] = $item['name'].' ';
                    $brosis[$i]['id'] = $id;
                    $i++;
                }
            }
            $i = 0;
            foreach($tmp2 as $id) {
                if($item['id'] == $id){
                    $child[$i]['word'] = $item['name'].' ';
                    $child[$i]['id'] = $id;
                    $i++;
                }
            }
            $i = 0;
            foreach($tmp3 as $id) {
                if($item['id'] == $id){
                    $relative[$i]['word'] = $item['name'].' ';
                    $relative[$i]['id'] = $id;
                    $i++;
                }
            }
        }

        $position = array();
        foreach($tmp4 as &$item) {
            $position[] = $hash['position'][$item]['word'];
        }
        unset($item);

        $work = $res['work']!='' ? $hash['work'][$res['work']]['word'].' ' : '' ;

        //get group
        $groups = array();
        $res2 = GroupRepository::getGroup(implode(' and ', array(
            'upid='.$res['id'],
            'year='.date('Y')
            )));
        $res2 = json_decode(json_encode($res2), true);
        
        if(count($res2) > 0) {
            foreach($res2 as $item) {
                $groups[] = $hash['group_type'][$item['type']]['word'].'('.$hash['group'][$item['group']]['word'].')';
            }
        }

        $data = array();
        $data['upid'] = $res['id'];
        $data['uid'] = $res['uid'];
        $data['first_name'] = $res['first_name'];
        $data['last_name'] = $res['last_name'];
        $data['type'] = $res['type'];
        $data['phone'] = $res['phone'];
        $data['mobile'] = $res['mobile'];
        $data['year'] = $res['year'];
        $data['work'] = $res['work']!='' ? $res['work']: '' ;
        $data['work_word'] = $work;
        $data['edu'] = $res['edu']!='' ? $res['edu'] : '';
        $data['edu_word'] = $res['edu']!='' ? $hash['edu'][$res['edu']]['word'] : '';
        $data['skill'] = $res['skill']!='' ? $res['skill'] : '';
        $data['skill_word'] = $res['skill']!='' ? $hash['skill'][$res['skill']]['word'] : '';
        $data['position'] = $res['position']!='' ? json_decode($res['position']) : array();
        $data['position_word'] = $position;
        $data['addr'] = $res['addr'];
        $data['name'] = $res['name'].'壇';
        $data['Dianchuanshi'] = $res['Dianchuanshi']=='' ? $res['Dianchuanshi_out'] : $res['Dianchuanshi'];
        $data['Introducer'] = $res['Introducer'];
        $data['Guarantor'] = $res['Guarantor'];

        $data['father'] = $res['father'];
        $data['father_id'] = $res['father_id'];
        $data['mother'] = $res['mother'];
        $data['mother_id'] = $res['mother_id'];
        $data['spouse'] = $res['spouse'];
        $data['spouse_id'] = $res['spouse_id'];
        $data['brosis'] = $brosis;
        $data['child'] = $child;
        $data['relative'] = $relative;
        $data['groups'] = implode(', ', $groups);

        return $data;
    }

    public static function getUsersByUpid($authID, $filter = 1, $upids = array(), $limit, $page)
    { 
        return DB::table('user as a')
                ->leftJoin('groups as g', 'a.id', '=', 'g.upid')
                ->leftJoin('user as b', 'a.Dianchuanshi', '=', 'b.id')
                ->leftJoin('regist as r', 'a.regist_id', '=', 'r.id')
                ->leftJoin('temple as t', 'r.tid', '=', 't.id')
                ->groupBy('a.id', 'g.type')
                ->orderBy('a.id', 'desc')
                ->whereIn('a.id', $upids)
                ->whereRaw(DB::Raw($filter))
                ->skip(($page-1) * $limit)
                ->take($limit)
                ->select('g.group','g.type as group_type','t.name',
                    'a.*',
                     DB::raw('concat(a.first_name, a.last_name) as name'),
                     DB::raw('concat(b.first_name, b.last_name) as Dianchuanshi_name'),
                     DB::Raw("case when t.upid=".$authID." then 1 else 0 end as `show`"))
                ->get();
    }

    public static function getUsers($authID, $filter = 1, $limit, $page)
    {
        return DB::table('user as a')
                ->leftJoin('groups as g', 'a.id', '=', 'g.upid')
                ->leftJoin('user as b', 'a.Dianchuanshi', '=', 'b.id')
                ->leftJoin('regist as r', 'a.regist_id', '=', 'r.id')
                ->leftJoin('temple as t', 'r.tid', '=', 't.id')
                ->groupBy('a.id', 'g.type')
                ->orderBy('a.id', 'desc')
                ->whereRaw(DB::Raw($filter))
                ->skip(($page-1) * $limit)
                ->take($limit)
                ->select('g.group','g.type as group_type','t.name','r.tid',
                    'a.*',
                     DB::raw('concat(b.first_name, b.last_name) as Dianchuanshi_name'),
                     DB::Raw("case when t.upid=".$authID." then 1 else 0 end as `show`"))
                ->get();
    }

    public static function getUsersByWhereIn($field, $vals)
    {
        return User::whereIn($field, $vals)
                    ->select('*', DB::Raw("concat(first_name, last_name) as name"))
                    ->get();
    }

    public static function getUserBoxInfo()
    {
        $res = DB::table('user as u')
                    ->join('regist as r', 'u.regist_id', '=', 'r.id')
                    ->join('temple as t', 'r.tid', '=', 't.id')
                    ->join('borrow_books as b', 'b.upid', '=', 'u.id')
                    ->where('u.id', '=', Auth::user()->id)
                    ->where('b.status', '=', 'out')
                    ->select('u.*', 't.*', DB::Raw('sum(b.count) as count'))
                    ->get();
        if(count($res) > 0)
            return $res[0];

        return array();
    }

    public static function getFullNameFromUpid($upid)
    {
        $res = User::where('id', '=', $upid)->get();
        if(count($res) > 0) {
            $res = $res[0];
            return $res['first_name'].$res['last_name'];
        }
    }
}