<?php

namespace App\Console\Commands;

use App\Models\AisDataVessel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class inaportnet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inaportnet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inaportnet API Request';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Set the API URL
        $url = 'https://api-inaportnet.dephub.go.id/public/api/simpadu/report/simpadu/getPergerakanKapal';

        // Set the API parameters
        $params = [
            'bulan' => Carbon::now()->format('m'), // Current month
            'tahun' => Carbon::now()->format('Y'), // Current year
            'kode_pelabuhan' => 'IDBDJ',
        ];

        // Make the HTTP POST request using Laravel HTTP client
        $response = Http::post($url, $params);

        // Check if the request was successful (status code 200)
        if ($response->successful()) {
            // Decode the JSON response
            $responseData = $response->json();

            // Extract the shipcall data from the response
            $shipcallData = $responseData['data']['shipcall'];

            // Save each shipcall entry to the database
            foreach ($shipcallData as $shipcall) {
                $vesselName = $shipcall['nama_kapal'];
                $noPkk = $shipcall['nomor_pkk'];

                $aisDataVessel = AisDataVessel::where('vessel_name', $vesselName)->first();

                // If the record is found, update no_pkk
                if ($aisDataVessel) {
                    $aisDataVessel->update([
                        'no_pkk' => $noPkk,
                        'jenis_layanan' => $shipcall['jenis_layanan'],
                        'nama_negara' => $shipcall['nama_negara'],
                        'tipe_kapal' => $shipcall['tipe_kapal'],
                        'nama_perusahaan' => $shipcall['nama_perusahaan'],
                        'tgl_tiba' => $shipcall['tgl_tiba'],
                        'tgl_brangkat' => $shipcall['tgl_brangkat'],
                        'bendera' => $shipcall['bendera'],
                        'gt_kapal' => $shipcall['gt_kapal'],
                        'dwt' => $shipcall['dwt'],
                        'nakhoda' => $shipcall['nakhoda'],
                        'jenis_trayek' => $shipcall['jenis_trayek'],
                        'pelabuhan_asal' => $shipcall['pelabuhan_asal'],
                        'pelabuhan_tujuan' => $shipcall['pelabuhan_tujuan'],
                        'lokasi_lambat_labuh' => $shipcall['lokasi_lambat_labuh'],
                        'nomor_spog' => $shipcall['nomor_spog'],
                    ]);
                }
            }

            // Output success message
            $this->info('ShipCall data saved successfully.');
        } else {
            // Output an error message if the request was not successful
            $this->error('Error: ' . $response->status());
        }
    }
}
