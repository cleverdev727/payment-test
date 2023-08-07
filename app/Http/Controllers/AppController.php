<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factor;
use Illuminate\View\View;
use App\Models\Transaction;
use Excepton;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AppController extends Controller
{
  /**
   * @return Application|Factor|View
   */
  public function create(Request $request): JsonResponse
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

    $transaction = new Transaction();
    $transaction->amount = $fields['payment_amount'];
    $transaction->customer_id = $fields['customer_id'];
    $transaction->customer_name = $fields['name'];
    $transaction->customer_mobile = $fields['mobile'];
    $transaction->customer_email = $fields['email'];
    $transaction->status = 'pending';

    $transaction->save();

    $fields['payment_ref_id'] = strval($transaction->id);
    // dd($fields);
    $response = Http::withOptions([
      'verify' => false, // Set CURLOPT_SSL_VERIFYPEER to false
    ])->withHeaders([
      'content-type' => 'application/json',
      'accountkey' => env('ACCOUNT_KEY'),
      'accountid' => env('ACCOUNT_ID')
    ])->post(env('API_URL') . env('CREATE_END_POINT'), $fields);

    $data = json_decode($response->body(), false);
    if ($response->status() == 200) {
      if ($data->status) {
        return response()->json($data);
      }
    } else {
      return response()->json($data);
    }
  }

  public function check(Request $request): JsonResponse
  {
    $fields = array();

    $id = $request->input('id');
    $row = Transaction::find($id);
    $fields['payment_ref_id'] = strval($row->id);
    $response = Http::withOptions([
      'verify' => false, // Set CURLOPT_SSL_VERIFYPEER to false
    ])->withHeaders([
      'content-type' => 'application/json',
      'accountkey' => env('ACCOUNT_KEY'),
      'accountid' => env('ACCOUNT_ID')
    ])->post(env('API_URL') . env('CHECK_END_POINT'), $fields);
    $data = json_decode($response->body(), false);
    if ($response->status() == 200) {
      if ($data->status) {
        return response()->json($data);
      }
    } else {
      return response()->json($data);
    }
  }
}