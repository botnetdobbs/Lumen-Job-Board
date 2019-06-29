<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'title',
        'company',
        'location',
        'job_description',
        'application_email'
    ];

    public function employer()
    {
        return $this->hasOne(User::class, 'employer_id');
    }
}
