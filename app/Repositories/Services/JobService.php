<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\JobInterface;
use Illuminate\Support\Facades\Auth;
use App\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class JobService implements JobInterface
{
    private $employer;

    public function __construct()
    {
        $this->employer = Auth::user();
    }

    /**
     * Add job
     *
     * @param array $job
     *
     * @return collection
     */
    public function createJob($job)
    {
        return $this->employer->addJob($job);
    }

    /**
     * Get all jobs belonging to the user/employer
     *
     * @return collection
     */
    public function getAllJobs()
    {
        return $this->employer->jobs()->get();
    }

    /**
     * Get specific job listing
     *
     * @param int $id
     * @return void
     */
    public function getSpecificJob($id)
    {
        try {
            $existingJob = $this->employer->jobs()->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Resource not found.'], 404);
        }

        return $existingJob;
    }

    /**
     * Update a job listing belonging to the user/employer
     *
     * @param array $job
     * @param int $id
     * @return response/collection
     */
    public function updateJob($job, $id)
    {
        try {
            $existingJob = $this->employer->jobs()->findOrFail($id);
            ;
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Resource not found.'], 404);
        }

        $existingJob->update($job);
        return $existingJob;
    }

    /**
     * Delete an existing job listing
     *
     * @param int $id
     * @return boolean
     */
    public function deleteJob($id)
    {
        $existingJob = $this->employer->jobs()->findOrFail($id);
        return $existingJob->delete();
    }
}
