<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $table = 'users_question';
    protected $fillable = ['seeker_id', 'expert_id', 'question_text','question_worth','email_optin', 'is_active'];

    public function seekersData()
    {
        return $this->belongsTo('App\User','seeker_id');
    }
    public function expertsData()
    {
        return $this->belongsTo('App\User','expert_id');
    }
}

