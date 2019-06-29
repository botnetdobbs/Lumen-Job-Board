<?php

namespace App\Repositories\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface JobApplicationInterface
{
    /**
     * Get all job applications for an applicant
     *
     * @return collection
     */
    public function getAllJobApplications();

    /**
     * get specific job application
     *
     * @param int $applicationId
     * @return collection
     */
    public function getSpecificJobApplication($applicationId);

    /**
     * Creates the application
     *
     * @param Request $request
     * @param int $id
     * @return collection
     */
    public function createJobApplication($request, $id);

    /**
     * Update a job upplication
     *
     * @param Request $request
     * @param int $id
     * @param int $applicationId
     * @return collection
     */
    public function updateJobApplication($request, $id, $applicationId);

    /**
     * Undocumented function
     *
     * @param int $applicationId
     * @return response
     */
    public function removeJobApplication($applicationId);
}
