<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildObject extends Model
{
    protected $fillable=['name', 'approve_id', 'starter_id'];
    public function starter()
    {
        return $this->belongsTo(User::class, 'starter_id');
    }
    public function approve()
    {
        return $this->belongsTo(User::class, 'approve_id');
    }

}
