<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factor;
use Illuminate\View\View;

class AppController extends Controller
{
  /**
   * @return Application|Factor|View
   */
  public function create()
  {
    $fields = array(
      'payment_ref_id'=> '1',
      'payment_amount'=> 100.00,
      'return_url'=> 'https://example.com/return',
      'customer_id'=> 'customer_1',
      'name'=> 'customer_name_1',
      'mobile'=> '1234567890',
      'email'=> 'customer@gmail.com',
      'remarks'=> '...'
    );
    $json_string = json_encode($fields);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, env('API_URL') . env('CREATE_END_POINT'));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'content-type: application/json',
      'accountkey: ' . env('ACCOUNT_KEY'),
      'accountid: ' . env('ACCOUNT_ID')
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
    $response = curl_exec($ch);
    curl_close($ch);
    echo "pre"; print_r($response);exit;
  }
}