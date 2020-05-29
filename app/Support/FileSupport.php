<?php
namespace App\Support;

class FileSupport
{
    public static function checkFile($file)
    {
        if (!$file->isValid()) {
            return ['status' => false, 'msg' => '文件上傳失敗'];
        }

        if ($file->getClientSize() > $file->getMaxFilesize()) {
            return ['status' => false, 'msg' => '文件大小不能大於2M'];
        }

        return ['status' => true];
    }
}