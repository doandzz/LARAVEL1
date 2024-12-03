<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class RollbackHocSinhImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rollback-hoc-sinh-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Logic để rollback
        $students = Student::whereNotNull('student_face_url')->get();

        foreach ($students as $student) {
            // Xóa file ảnh
            $faceUrls = explode(',', $student->student_face_url);
            foreach ($faceUrls as $url) {
                $path = str_replace('storage/', 'public/', $url); // Chuyển đổi đường dẫn
                if (file_exists($path)) {
                    unlink($path); // Xóa file
                }
            }
            // Đặt lại cột face_url về null hoặc giá trị cũ
            $student->update(['student_face_url' => null]);
        }

        $this->info('Rollback hoàn tất!');
    }
}
