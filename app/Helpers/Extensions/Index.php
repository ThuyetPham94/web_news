<?php

namespace App\Helpers\Extensions;

use Illuminate\Support\Facades\DB;
/**
 * MyClass Class Index Comment
 *
 * @category Class
 * @package  MyPackage
 * @author    Thuyetpv
 * @link
 *
 */
class Index
{
    /**
     * @param int $user_id User-id
     *
     * @return string
     */
    public static function getUserName($user_id)
    {
        $user = DB::table('users')->where('userid', $user_id)->first();

        return (isset($user->username) ? $user->username : '');
    }
}
