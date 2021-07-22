<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpertRating extends Model
{
    protected $table="expert_rating";
    protected $fillable = ['seeker_id','expert_id','feed_back','rating'];
    public function seekerData()
    {
        return $this->belongsTo('App\User',"seeker_id");
    }
}
