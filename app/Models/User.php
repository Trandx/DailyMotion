<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //'email_verified_at' => 'datetime',
        // "phones" => "array",
        // 'email' => 'array',
        // 'avatar' => 'array'
    ];

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';



       /**
     * Find the user instance for the given phone_number.
     *
     * @param  string  $phone
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        //return $this->where('phone', $username)->->first();
       // return self::firstWhere('email->active', $username) ?? self::firstWhere('phone->active',  $username);
       return self::where('email', $username)
                ->orWhere('phone',  $username)
                ->orWhere('username',  $username)
                ->orWhere('social_id',  $username)->first();


    }

    public function validateForPassportPasswordGrant($password)
    {
        // if($password == "social_auth"){
        //     return true;
        // }

        return true;

    }
    // /**
    //  * this function find user with email or username or phone and password
    //  *
    //  * Undocumented function long description
    //  *
    //  * @param Type $var Description
    //  * @return type
    //  * @throws conditon
    //  **/
    // public static function AuthByPhoneOrEmailOrUsername(Object $args)
    // {
    //     return self::where(['email->active' => $args->login, "password" =>   $args->password])
    //     ->orWhere(['phones->active' =>  $args->login, "password" =>   $args->password])
    //     ->orWhere(['username' =>  $args->login, "password" =>   $args->password]);
    // }

        /**
     * custom boot user ids
     */

    public static function boot()
    {

        parent::boot();

        self::creating(function ($model) {

            $model->id = Uuid::uuid4()->toString();

        });

    }







}
