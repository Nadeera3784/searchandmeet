<?php

namespace App\Models;

use App\Models\Communication\Conversation;
use App\Traits\Hashidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Enums\Agent\AgentRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Hashidable;
    public $type = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'timezone_id',
        'country_id',
        'status',
        'role',
        'profile_picture_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'role' => AgentRoles::class,
    ];

    public function timezone()
    {
        return $this->belongsTo(TimeZone::class, 'timezone_id');
    }

    public function profile_picture()
    {
        if($this->profile_picture_id)
        {
            return Image::find($this->profile_picture_id);
        }

        return null;
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_users', 'user_id', 'conversation_id');
    }

}
