<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'subject',
        'cv_description',
        'applicant_id'
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    
    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }
}
