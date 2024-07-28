<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FileType;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FileType::create([
            'type' => 'Document',
            'extensions' => 'doc,docx,pdf',
            'description' => 'Common document file types'
        ]);

        FileType::create([
            'type' => 'Powerpoint',
            'extensions' => 'ppt,pptx',
             'description' => 'Microsoft Powerpoint presentation files'
        ]);

        FileType::create([
            'type' => 'Image',
            'extensions' => 'jpg,jpeg,png,gif',
            'description' => 'Image file types'
        ]);

        FileType::create([
            'type' => 'Video',
            'extensions' => 'mp4,avi,mov',
            'description' => 'Video file types'
        ]);

        FileType::create([
            'type' => 'PDF',
            'extensions' => 'pdf',
            'description' => 'Portable Document Format'
        ]);
    }
}