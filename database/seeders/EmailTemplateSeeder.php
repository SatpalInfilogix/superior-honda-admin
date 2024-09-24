<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'email_template' => 'order',
                'description' => 'Username: {{user_name}}, Order Id: {{order_id}}, Order Detail:  {{order_summary}}, Order placed date: {{created_at}}, Grand Total: {{formatted_grand_total}}, Today Date: {{date}}',
            ], [
                'email_template' => 'verify_otp',
                'description' => 'Username: {{user_name}}, Otp: {{otp}} Today Date: {{date}}',
            ], [
                'email_template' => 'registration',
                'description' => 'Username: {{user_name}}, Today Date: {{date}}',
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::create($template);
        }
    }
}
