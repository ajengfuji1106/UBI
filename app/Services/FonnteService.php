<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class FonnteService
{
    protected $apiUrl = 'https://api.fonnte.com/send';

    public function sendMessage($to, $message)
    {
        return Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'),
        ])->post($this->apiUrl, [
            'target' => $to,
            'message' => $message,
            'countryCode' => '62',
        ])->json();
    }
    public function formatNomorInternasional($nomor)
{
    $nomor = preg_replace('/[^0-9]/', '', $nomor);

    if (substr($nomor, 0, 1) === '0') {
        return '62' . substr($nomor, 1);
    }

    return $nomor; 
}

}
