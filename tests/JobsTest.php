<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\Role;
use App\User;

class JobsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jobData = [
            'title' => 'Software Developer',
            'company' => 'Westwood inc',
            'location' => 'Nairobi',
            'job_description' => 'Expected to play a key role in the design, installation, testing and maintenance of our software systems',
            'application_email' => 'applications@westwood.inc'
        ];

        $this->notAuthorized = [
            'status' => 'error', 'message' => 'Not allowed'
        ];
    }

    /**
     * @test
     *
     */
    public function employerShouldBeAbleToCreateJobs()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $this->be($user);

        $response = $this->post('/api/v1/jobs', $this->jobData);

        $response->assertResponseStatus(201);
        $response->seeJson($this->jobData);
    }

    /**
     * @test
     */

    public function nonEmployerShouldNotBeAbleToCreateJobs()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $this->be($user);

        $response = $this->post('/api/v1/jobs', $this->jobData);

        $response->assertResponseStatus(403);
        $response->seeJson($this->notAuthorized);
    }

    /**
     * @test
     *
     * NB: This endpoint can be accessed by any authenticated user. Response will be different
     */
    public function employerShouldBeAbleToViewAllOwnAvailableJobs()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $this->be($user);
        $user->addJob($this->jobData);

        $response = $this->get('/api/v1/jobs');

        $response->assertResponseStatus(200);
        $response->seeJson($this->jobData);
    }

    /**
     * @test
     *
     */
    public function employerShouldBeAbleToUpdateOwnCreatedJob()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $job = $user->addJob($this->jobData);
        $this->be($user);
        // Update title
        $this->jobData['title'] = 'Update';

        $response = $this->put("/api/v1/jobs/{$job->id}", $this->jobData);

        $response->assertResponseStatus(200);
        $response->seeJson($this->jobData);
    }

    /**
     * @test
     *
     */
    public function employertryingToUpdateNonExistingJobPostingReturns404()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $this->be($user);

        $response = $this->put("/api/v1/jobs/1", $this->jobData);

        $response->assertResponseStatus(404);
    }

    /**
     * @test
     *
     */
    public function employerShouldNotBeAbleToUpdateOtherEmployersJobs()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        // assign another title to the jobData
        $this->jobData['title'] = 'Not visible';
        $otherUserJobPosting = $user->addJob($this->jobData);
        $user1 = factory(User::class)->create();
        $user1->roles()->attach($role);
        $user1->addJob($this->jobData);
        $this->be($user1);

        $response = $this->put("/api/v1/jobs/{$otherUserJobPosting->id}", $this->jobData);

        $response->assertResponseStatus(404); // We use the relationship to get the employers job postings hence the 404
    }

    /**
     * @test
     * 
     * NB: This endpoint can be accessed by any authenticated user
     *
     */
    public function employerShouldBeAbleToViewSpecificOwnJob()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $job = $user->addJob($this->jobData);
        $this->be($user);

        $response = $this->get("/api/v1/jobs/{$job->id}");

        $response->assertResponseStatus(200);
        $response->seeJson($this->jobData);
    }

    /**
     * @test
     * 
     * NB: This endpoint can be accessed by any authenticated user
     */
    public function tryingToviewNonExistingJobPostingreturns404()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $this->be($user);

        $response = $this->get("/api/v1/jobs/1");

        $response->assertResponseStatus(404);
    }

    /**
     * @test
     *
     * NB: We use the relationship to get the employers job postings hence the cannot edit others'
     */
    public function employerShouldBeAbleToDeleteOwnJobListing()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $job = $user->addJob($this->jobData);
        $this->be($user);

        $response = $this->delete("/api/v1/jobs/{$job->id}");

        $response->assertResponseStatus(204);
    }

    /**
     * 
     * 
     *
     * NB: We use the relationship to get the employers job postings hence the cannot edit others'
     */
    public function employerShouldReceive404whenDeletingNonExistingJobListing()
    {
        $role = factory(Role::class)->create();
        $user = factory(User::class)->create();
        $user->roles()->attach($role);
        $this->be($user);

        $response = $this->delete("/api/v1/jobs/1");

        $response->assertResponseStatus(404);
    }
}
