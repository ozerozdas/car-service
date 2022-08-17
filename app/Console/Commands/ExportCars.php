<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Cars;

class ExportCars extends Command
{
    /**
     * @var string
     */
    private $carsEndpoint;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:cars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will export cars into your database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->carsEndpoint = env('AUTOMOBILE_URL');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cars = $this->getCars();
        $data = !empty($cars['RECORDS']) ? $cars['RECORDS'] : [];
        if($data){
            DB::beginTransaction();

            try {
                Cars::truncate();
                for ($i=0; $i < ceil(count($data) / 1000); $i++) {
                    Cars::insert(array_slice($data, $i * 1000, 1000));
                }
            } catch (\Throwable $th) {
                DB::rollBack();
            }

            DB::commit();
            $this->info('The export was successful!');
        }
        return 0;
    }

    private function getCars(){
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->carsEndpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception("Error Processing Request", 1);
        }
        return json_decode($response, true);
    }
}
