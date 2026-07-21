<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Welcome to the New HRIS Platform',
                'content' => 'We are excited to announce the launch of our new HR Information System. This platform will streamline all HR processes including attendance, leave management, payroll, and performance reviews.',
                'type' => 'achievement',
                'is_pinned' => true,
                'is_published' => true,
                'published_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Office Closure for National Holiday',
                'content' => 'Please note that the office will be closed on August 17th in observance of Independence Day. All employees are advised to plan their leave accordingly.',
                'type' => 'warning',
                'is_pinned' => false,
                'is_published' => true,
                'published_at' => Carbon::now()->subDay(),
            ],
            [
                'title' => 'Quarterly Performance Review Reminder',
                'content' => 'The Q3 performance review cycle is now active. Please ensure all goals are updated and reviews are submitted before the deadline.',
                'type' => 'info',
                'is_pinned' => false,
                'is_published' => true,
                'published_at' => Carbon::now(),
            ],
        ];

        foreach ($announcements as $data) {
            $data['created_by'] = 1;
            Announcement::create($data);
        }
    }
}
