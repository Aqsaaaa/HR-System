<?php

namespace Database\Seeders;

use App\Models\Candidate;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        $jobs = [
            [
                'position_id' => 1,
                'title' => 'Senior PHP Developer',
                'description' => 'We are looking for an experienced PHP developer to join our engineering team and help build our HRIS platform.',
                'requirements' => "- 5+ years PHP experience\n- Laravel expertise\n- Vue.js or React knowledge\n- MySQL and Redis experience\n- API design skills",
                'responsibilities' => "- Develop and maintain backend services\n- Design RESTful APIs\n- Code review and mentoring\n- Performance optimization",
                'salary_min' => 15000000,
                'salary_max' => 25000000,
                'location' => 'Jakarta',
                'type' => 'full_time',
                'status' => 'published',
                'slots' => 2,
                'posted_at' => Carbon::parse('2000-07-27'),
            ],
            [
                'position_id' => 3,
                'title' => 'UI/UX Designer',
                'description' => 'Join our product team to design intuitive and beautiful interfaces for our HR applications.',
                'requirements' => "- 3+ years UI/UX experience\n- Figma proficiency\n- Design system experience\n- User research skills",
                'responsibilities' => "- Create wireframes and prototypes\n- Conduct user research\n- Maintain design system\n- Collaborate with developers",
                'salary_min' => 10000000,
                'salary_max' => 18000000,
                'location' => 'Bandung',
                'type' => 'full_time',
                'status' => 'published',
                'slots' => 1,
                'posted_at' => Carbon::parse('2000-07-29'),
            ],
            [
                'position_id' => 5,
                'title' => 'Marketing Intern',
                'description' => 'Great opportunity for students or fresh graduates to learn marketing in a SaaS company.',
                'requirements' => "- Currently pursuing or recent graduate in Marketing\n- Basic social media skills\n- Good communication\n- Eager to learn",
                'responsibilities' => "- Assist with social media content\n- Help organize events\n- Market research\n- Content writing",
                'salary_min' => 3000000,
                'salary_max' => 5000000,
                'location' => 'Jakarta',
                'type' => 'internship',
                'status' => 'published',
                'slots' => 3,
                'posted_at' => Carbon::parse('2000-07-31'),
            ],
        ];

        foreach ($jobs as $data) {
            $data['created_by'] = 1;
            JobPosting::create($data);
        }

        $candidates = [
            ['first_name' => 'Ahmad', 'last_name' => 'Fauzi', 'email' => 'ahmad.fauzi@email.com', 'phone' => '081234567890', 'source' => 'LinkedIn'],
            ['first_name' => 'Siti', 'last_name' => 'Nurhaliza', 'email' => 'siti.nurhaliza@email.com', 'phone' => '081234567891', 'source' => 'Jobstreet'],
            ['first_name' => 'Budi', 'last_name' => 'Santoso', 'email' => 'budi.santoso@email.com', 'phone' => '081234567892', 'source' => 'Referral'],
            ['first_name' => 'Dewi', 'last_name' => 'Lestari', 'email' => 'dewi.lestari@email.com', 'phone' => '081234567893', 'source' => 'LinkedIn'],
            ['first_name' => 'Rudi', 'last_name' => 'Hermawan', 'email' => 'rudi.hermawan@email.com', 'phone' => '081234567894', 'source' => 'Company website'],
            ['first_name' => 'Rina', 'last_name' => 'Wijaya', 'email' => 'rina.wijaya@email.com', 'phone' => '081234567895', 'source' => 'LinkedIn'],
            ['first_name' => 'Agus', 'last_name' => 'Prasetyo', 'email' => 'agus.prasetyo@email.com', 'phone' => '081234567896', 'source' => 'Jobstreet'],
            ['first_name' => 'Maya', 'last_name' => 'Anggraini', 'email' => 'maya.anggraini@email.com', 'phone' => '081234567897', 'source' => 'Referral'],
            ['first_name' => 'Doni', 'last_name' => 'Kurniawan', 'email' => 'doni.kurniawan@email.com', 'phone' => '081234567898', 'source' => 'Company website'],
            ['first_name' => 'Ani', 'last_name' => 'Rahmawati', 'email' => 'ani.rahmawati@email.com', 'phone' => '081234567899', 'source' => 'LinkedIn'],
        ];

        $stages = ['applied', 'applied', 'screening', 'screening', 'interview', 'interview', 'offer', 'applied', 'applied', 'screening'];

        foreach ($candidates as $i => $data) {
            $data['created_by'] = 1;
            $candidate = Candidate::create($data);

            $jobId = ($i % 3) + 1;
            JobApplication::create([
                'job_posting_id' => $jobId,
                'candidate_id' => $candidate->id,
                'stage' => $stages[$i],
                'status' => 'active',
                'applied_at' => Carbon::parse('2000-08-0' . (($i % 9) + 1)),
                'created_by' => 1,
            ]);
        }
    }
}
