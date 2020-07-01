<?php

use Illuminate\Database\Seeder;
use App\FileType;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FileType::create(
            ['id' => 0, 'extension' => 'JPG'],
        );
        
        FileType::create(
            ['id' => 0, 'extension' => 'PDF'],
        );
        
        FileType::create(
            ['id' => 0, 'extension' => 'MP4'],
        );
    }
}
