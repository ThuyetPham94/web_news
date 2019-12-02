<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Carbon\Carbon;
/**
 * Class User
 *
 * @package App
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'sur_and_last_name',
        'phone_number',
        'email',
        'facebook_id',
        'password',
        'photo',
        'remember_token',
        'token_firebase',
        'device_type',
        'is_suspend',
        'is_active',
        'is_admin',
        'number_of_images_to_display',
        'display_image_and_text_type',
        'display_text_type',
        'display_list_type',
        'language_type',
        'text_size',
        'introduction',
        'login_type',
        'expire_time'
    ];

    protected $appends = ['role'];

    protected $casts = [
        'birthday' => 'datetime:Y-m-d',
    ];

    // public function setBirthdayAttribute($value)
    // {
    //     $this->attributes['birthday'] = Carbon::parse($value)->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d');;
    // }

    public function getRoleAttribute()
    {
        if($this->attributes['is_admin'] == 1) {
            return 'admin';
        }
        return 'user';
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function checkPermission($type) {
        return $this->type === $type;
    }
}
