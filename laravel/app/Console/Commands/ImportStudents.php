<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ImportStudents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:students {file}';

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
        $filePath = $this->argument('file');

        if (!file_exists($filePath) || !is_readable($filePath)) {
            $this->error("The file does not exist or is not readable.");
            return 1;
        }

        // Open the CSV file
        $file = fopen($filePath, 'r');

        // Skip the header row (nếu CSV có header)
        $header = fgetcsv($file);


        // Import từng dòng vào bảng students
        while (($data = fgetcsv($file)) !== false) {

            $gt= $data[4] == 'Nam' ? 1 : 0;

            // Chuyển đổi ngày từ dd/mm/yyyy sang yyyy-mm-dd
            $birthDate = Carbon::createFromFormat('d/m/Y', $data[5])->format('Y-m-d');
            
            DB::table('students')->insert([
                'student_identification_code' => $data[0],
                'student_code' => $data[1],
                'full_name' => $data[2],
                'class_id' => $data[3],
                'gender' => $gt,
                'birth_date' => $birthDate,
                'birthplace' => $data[6],
                'address' => $data[7],
                'guardian_full_name' => $data[8],
                'guardian_phone' => $data[9],
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        fclose($file);

        $this->info('Students imported successfully!');
        return 0;
    }
}
