<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Security',
                'name_ar' => 'الأمن',
                'department_id' => 2,
            ],
            [
                'name' => 'Management',
                'name_ar' => 'الإدارة',
                'department_id' => 2,
            ],
            [
                'name' => 'Infrastructure',
                'name_ar' => 'البنية التحتية',
                'department_id' => 2,
            ],
            [
                'name' => 'Recruitment & Staffing',
                'name_ar' => 'التوظيف والموارد البشرية',
                'department_id' => 1,
            ],
            [
                'name' => 'Training & Development',
                'name_ar' => 'التدريب والتطوير',
                'department_id' => 1,
            ],
            [
                'name' => 'Financial Accounting',
                'name_ar' => 'المحاسبة المالية',
                'department_id' => 3,
            ],
            [
                'name' => 'Cost Accounting',
                'name_ar' => 'محاسبة التكاليف',
                'department_id' => 3,
            ],
        ]);
    }
}
