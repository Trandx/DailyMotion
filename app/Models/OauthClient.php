<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class OauthClient extends Model
{
    use HasFactory;

    public $incrementing = false;


    /**
    *The attributes that are not mass assignable.
    *
    * @var Array $guarded <int, string>
    */

    protected $guarded = ["id"];
     // All fields inside the $guarded array are not mass-assignable
     //


    protected $keyType = 'string';

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

          /**
     * Get user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        //return $this->setConnection('mysql')->belongsTo(User::class);
        return $this->belongsTo(User::class);
    }


}
