<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\JobInterface;

class JobsController extends Controller
{
    private $jobService;

    public function __construct(JobInterface $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * Return all the all jobs
     *
     * @return response
     */
    public function index()
    {
        return $this->jobService->getAllJobs();
    }

    /**
     * Get specific job
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        return $this->jobService->getSpecificJob($id);
    }

    /**
     * Create a job
     *
     * @param Request $request
     * @return response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'job_description' => 'required|string',
            'application_email' => 'required|string'
        ]);

        $job = $this->jobService->createJob($request->all());

        return response()->json($job, 201);
    }

    /**
     * Update existing job listing
     *
     * @param Request $request
     * @return response
     */
    public function Update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'job_description' => 'required|string',
            'application_email' => 'required|string'
        ]);

        return $this->jobService->updateJob($request->all(), $id);
    }

    /**
     * Delete an existing job
     *
     * @param int $id
     * @return response
     */
    public function destroy($id)
    {
        $this->jobService->deleteJob($id);
        return response()->json([], 204);
    }
}
