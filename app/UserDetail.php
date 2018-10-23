<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';

    protected $fillable = ['bio', 'about', 'gender', 'profile_pic', 'skills', 'job_type'];
}
