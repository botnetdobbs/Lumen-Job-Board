<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\JobApplicationInterface;

class ApplicationsController extends Controller
{
    private $jobApplicationService;

    public function __construct(JobApplicationInterface $jobApplicationService)
    {
        $this->jobApplicationService = $jobApplicationService;
    }

    /**
     * Job applications
     *
     * @return void
     */
    public function index()
    {
        return $this->jobApplicationService->getAllJobApplications();
    }

    /**
     * get a specific job application
     *
     * @param int $applicationId
     * @return response
     */
    public function show($applicationId)
    {
        return $this->jobApplicationService->getSpecificJobApplication($applicationId);
    }

    /**
     * Create new application
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'subject' => 'required|string',
            'cv_description' => 'required'
        ]);

        $data = $this->jobApplicationService->createJobApplication($request, $id);
        return response()->json($data, 201);
    }

    /**
     * Update existing application
     *
     * @param Request $request
     * @param int $id
     * @param int $applicationId
     * @return void
     */
    public function update(Request $request, $id, $applicationId)
    {
        $this->validate($request, [
            'subject' => 'required|string',
            'cv_description' => 'required'
        ]);

        return $this->jobApplicationService->updateJobApplication($request, $id, $applicationId);
    }

    /**
     * Delete an application
     *
     * @param int $applicationId
     * @return response
     */
    public function destroy($applicationId)
    {
        return $this->jobApplicationService->removeJobApplication($applicationId);
    }
}
