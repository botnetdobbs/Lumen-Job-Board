<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Role;
use App\User;

class ApplicationsTest extends TestCase
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

        $this->applicationData = [
            'subject' => 'Interested in the role of software dev',
            'cv_description' => 'One year experience'
        ];
        $this->job = $this->createJob();
    }

    /**
     * Create job for testing applications
     */
    public function createJob()
    {
        $role = factory(Role::class)->create(['name' => 'employer']);
        $employer = factory(User::class)->create();
        $employer->roles()->attach($role);
        return $employer->addJob($this->jobData);
    }

    /**
     * @test
     *
     */
    public function applicantCanViewAllApplications()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $this->be($applicant);
        $job = $applicant->addJob($this->jobData);
        $this->applicationData['applicant_id'] = $applicant->id;
        $job->addApplication($this->applicationData);
        
        $response = $this->get("api/v1/jobs/{$this->job->id}/applications/");
        
        unset($this->applicationData['applicant_id']);
        $response->assertResponseStatus(200);
        $response->seeJson($this->applicationData);
    }

    /**
     * @group test
     * @test
     *
     */
    public function applicantCanViewSpecificApplications()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $this->be($applicant);
        $job = $applicant->addJob($this->jobData);
        $this->applicationData['applicant_id'] = $applicant->id;
        $application = $job->addApplication($this->applicationData);
        
        $response = $this->get("api/v1/jobs/{$this->job->id}/applications/{$application->id}");
        
        // returned applicant id is of type string hence unsetting the integer we have
        unset($this->applicationData['applicant_id']);
        $response->assertResponseStatus(200);
        $response->seeJson($this->applicationData);
    }

    /**
     * @test
     *
     */
    public function anApplicantCanSendAnApplication()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $this->be($applicant);

        $response = $this->post("api/v1/jobs/{$this->job->id}/applications", $this->applicationData);
        
        $response->assertResponseStatus(201);
        $response->seeJson($this->applicationData);
    }

    /**
     * @test
     *
     */
    public function anApplicantCanUpdateAnApplication()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $this->be($applicant);
        $job = $applicant->addJob($this->jobData);
        //Add applicant_id
        $this->applicationData['applicant_id'] = $applicant->id;
        $application = $job->addApplication($this->applicationData);

        // Update subject before submitting
        $this->applicationData['subject'] = 'New Subject';
        //Unset applicant_id
        unset($this->applicationData['applicant_id']);
        $response = $this->put("api/v1/jobs/{$this->job->id}/applications/{$application->id}", $this->applicationData);
        
        $response->assertResponseStatus(200);
        $response->seeJson($this->applicationData);
    }

    /**
     * @test
     *
     */
    public function applicantCannotEditOthersApplications()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $job = $applicant->addJob($this->jobData);
        //Add applicant_id
        $this->applicationData['applicant_id'] = $applicant->id;
        $application = $job->addApplication($this->applicationData);

        //create and authorize another applicant
        $applicant1 = factory(User::class)->create();
        $applicant1->roles()->attach($role);
        $this->be($applicant1);
        // Update subject before submitting
        $this->applicationData['subject'] = 'New Subject';
        //Unset applicant_id
        unset($this->applicationData['applicant_id']);
        $response = $this->put("api/v1/jobs/{$this->job->id}/applications/{$application->id}", $this->applicationData);
        
        $response->assertResponseStatus(403);
    }

    /**
     * @test
     *
     */
    public function anApplicantCanDeleteAnApplication()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $this->be($applicant);
        $job = $applicant->addJob($this->jobData);
        //Add applicant_id
        $this->applicationData['applicant_id'] = $applicant->id;
        $application = $job->addApplication($this->applicationData);

        $response = $this->delete("api/v1/jobs/{$this->job->id}/applications/{$application->id}");
        
        $response->assertResponseStatus(204);
    }

    /**
     * @test
     *
     */
    public function anApplicantCannotDeleteOthersApplications()
    {
        $role = factory(Role::class)->create(['name' => 'applicant']);
        $applicant = factory(User::class)->create();
        $applicant->roles()->attach($role);
        $job = $applicant->addJob($this->jobData);
        //Add applicant_id
        $this->applicationData['applicant_id'] = $applicant->id;
        $application = $job->addApplication($this->applicationData);

        //create and authorize another applicant
        $applicant1 = factory(User::class)->create();
        $applicant1->roles()->attach($role);
        $this->be($applicant1);

        $response = $this->delete("api/v1/jobs/{$this->job->id}/applications/{$application->id}", $this->applicationData);
        
        $response->assertResponseStatus(403);
    }
}
