<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\JobApplicationInterface;
use App\Job;
use App\Application;
use Illuminate\Support\Facades\Auth;

class JobApplicationService implements JobApplicationInterface
{
    private $job;
    private $applicant;

    public function __construct(Job $job)
    {
        $this->job = $job;
        $this->applicant = Auth::user();
    }

    /**
     * Get all job applications for an applicant
     *
     * @return collection
     */
    public function getAllJobApplications()
    {
        return $this->applicant->jobApplications()->get();
    }

    /**
     * get specific job application
     *
     * @param int $applicationId
     * @return collection
     */
    public function getSpecificJobApplication($applicationId)
    {
        return Application::find($applicationId);
    }

    /**
     * Creates the application
     *
     * @param Request $request
     * @param int $id
     * @return collection
     */
    public function createJobApplication($request, $id)
    {
        $data = $request->all();
        $data['applicant_id'] = $request->user()->id;
        $job = $this->job->find($id);

        return $job->addApplication($data);
    }

    /**
     * Update a job upplication
     *
     * @param Request $request
     * @param int $id
     * @param int $applicationId
     * @return collection
     */
    public function updateJobApplication($request, $id, $applicationId)
    {
        $application = Application::find($applicationId);
        
        if ((int)$application->applicant_id === (int)$request->user()->id) {
            $application->update($request->all());
            return $application;
        } else {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], 403);
        }
    }

    /**
     * Undocumented function
     *
     * @param int $applicationId
     * @return response
     */
    public function removeJobApplication($applicationId)
    {
        $application = Application::find($applicationId);
        if ((int)$application->applicant_id === (int)$this->applicant->id) {
            $application->delete();
            return response()->json([], 204);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Not authorized.'], 403);
        }
    }
}
