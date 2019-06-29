<?php

namespace App\Repositories\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface JobInterface
{
    /**
     * Add job
     *
     * @param array $job
     *
     * @return collection
     */
    public function createJob($job);

    /**
     * Get all jobs belonging to the user/employer
     *
     * @return collection
     */
    public function getAllJobs();

    /**
     * Update a job listing belonging to the user/employer
     *
     * @param array $job
     * @param int $id
     * @return response/collection
     */
    public function updateJob($job, $id);

    /**
     * Delete an existing job listing
     *
     * @param int $id
     * @return void
     */
    public function deleteJob($id);
}
