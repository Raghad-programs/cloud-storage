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
            'extensions' => 'doc,docx,pdf'
        ]);

        FileType::create([
            'type' => 'Powerpoint',
            'extensions' => 'ppt,pptx'
        ]);

        FileType::create([
            'type' => 'Image',
            'extensions' => 'jpg,jpeg,png,gif'
        ]);

        FileType::create([
            'type' => 'Video',
            'extensions' => 'mp4,avi,mov'
        ]);

        FileType::create([
            'type' => 'PDF',
            'extensions' => 'pdf'
        ]);
    }
}