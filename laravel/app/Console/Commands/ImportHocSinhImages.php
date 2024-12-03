<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportHocSinhImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-hoc-sinh-images';

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
        $lopFolders = Storage::disk('suoihoa')->directories(); 

        foreach ($lopFolders as $lopFolder) {
            $maHocSinhFolders = Storage::disk('suoihoa')->directories($lopFolder);

            foreach ($maHocSinhFolders as $maHocSinhFolder) {
                $maHocSinh = basename($maHocSinhFolder);

                // Tìm học sinh theo mã
                $hocSinh = Student::where('student_identification_code', $maHocSinh)
                ->orWhere('student_code', $maHocSinh)
                ->first();
                if (!$hocSinh) {
                    $this->warn("Không tìm thấy học sinh với mã: $maHocSinh");
                    continue;
                }

                // Lấy tối đa 4 file ảnh
                $files = array_slice(Storage::disk('suoihoa')->files($maHocSinhFolder), 0, 4);
                $urls = [];

                foreach ($files as $file) {
                    $filename = Str::random(5) . '_' . basename($file); // Tạo tên file mới
                    $destination = "images/$filename"; // Thư mục lưu mới

                    // Di chuyển ảnh vào storage/app/public/images
                    Storage::disk('public')->put($destination, Storage::disk('suoihoa')->get($file));

                    // Tạo URL cho ảnh
                    $urls[] = 'images/' . $filename;
                }

                // Ghép các URL bằng dấu phẩy
                $faceUrl = implode(',', $urls);

                // Cập nhật face_url cho học sinh
                $hocSinh->update(['student_face_url' => $faceUrl]);
            }
        }

        $this->info('Import hoàn tất!');
    }
}
