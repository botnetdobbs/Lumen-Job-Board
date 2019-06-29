<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Application;

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
        return $this->belongsTo(User::class, 'employer_id');
    }

    public function jobApplications()
    {
        return $this->hasMany(Application::class);
    }

    public function addApplication($application)
    {
        return $this->jobApplications()->create($application);
    }

    public function jobApplicants()
    {
        return $this->hasManyThrough(User::class, Application::class);
    }
}
