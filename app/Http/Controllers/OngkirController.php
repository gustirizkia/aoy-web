<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use DB;
use GuzzleHttp\Exception\BadResponseException;

class OngkirController extends Controller
{
    public function getProvince()
    {
        $client = new Client();
        $data = $client->get('https://pro.rajaongkir.com/api/province',[
            'headers' => [
                // 'key' => 'a906fd8fc45a816184224df29f246d93'
                'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
        ]);

        $provincies = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $provincies
        ], 200);
    }

    public function getCity(Request $request)
    {
        $client = new Client();
        $data = $client->get('https://pro.rajaongkir.com/api/city?province=' . $request->provinsi,[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
        ]);

        $cities = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $cities
        ], 200);
    }

    public function getSubdistrict(Request $request)
    {
        $client = new Client();
        $data = $client->get('https://pro.rajaongkir.com/api/subdistrict?city=' . $request->city_id,[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
        ]);

        $subdistrict = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $subdistrict
        ], 200);
    }

    public function checkEbook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'city_id' => 'required',
            // 'subdistrict_id' => 'required'
            'invoice' => 'required',
            'address_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400);
        }

        // Check Invoice
        $exits = DB::table('orders')->where('invoice', $request->invoice)->first();
        if (!$exits) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invoice tidak ditemukan'
            ], 400);
        }

        // Check address
        $address = DB::table('user_address')->where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();
        if (!$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Alamat tidak ditemukan'
            ], 404);
        }

        // Get weight product
        $weight = DB::table('orders')
                    ->where('invoice', $request->invoice)
                    ->join('types_product_warisan', 'types_product_warisan.type_warisan_id', 'orders.type_warisan_id')
                    ->get()
                    ->sum('weight_product');

        // Check if product not found or weight = 0
        if ($weight == 0) {
            $weight = 1;
        }

        $client = new Client();

        $data = $client->post('https://pro.rajaongkir.com/api/cost',[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => 457,
                'originType' => 'city',
                'destination' => $address->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => 'jne:tiki:jnt:sicepat'
            ]
        ]);

        $res = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $res
        ], 200);
    }

    public function checkEbookByWarehouse(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'city_id' => 'required',
            // 'subdistrict_id' => 'required'
            'invoice' => 'required',
            'address_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400);
        }

        // Check Invoice
        $exits = DB::table('orders')->where('invoice', $request->invoice)->first();
        if (!$exits) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invoice tidak ditemukan'
            ], 400);
        }

        // Check address
        $address = DB::table('user_address')->where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();
        if (!$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Alamat tidak ditemukan'
            ], 404);
        }

        // Get weight product
        $weight = DB::table('orders')
                    ->where('invoice', $request->invoice)
                    ->join('types_product_warisan', 'types_product_warisan.type_warisan_id', 'orders.type_warisan_id')
                    ->get()
                    ->sum('weight_product');

        // Check if product not found or weight = 0
        if ($weight == 0) {
            $weight = 1;
        }

        /**
        *
        * FLOW CHEKOUT LAMA, OTOMATIS GET DARI GUDANG TERDEKAT BERDASARKAN ALAMAT USER
        *
        **/

        //cek gudang terdekat
        // $check_warehouse = DB::table('warehouses')->where('status', 'confirmed')->where('warehouse_status', 1)->get();
        //
        // if (!$check_warehouse->isEmpty()) {
        //   $cities_ro_user =  DB::table('cities_ro')->where('city_id', $address->city_id)->first();
        //   // cari yang terdekat
        //   $user_latitude = $cities_ro_user->latitude;
        //   $user_longitude = $cities_ro_user->longitude;
        //
        //   $distance = array();
        //
        //   foreach($check_warehouse as $w){
        //     $cities_ro_warehouse =  DB::table('cities_ro')->where('city_id', $w->city_id)->first();
        //     $distance = $this->distance($cities_ro_warehouse->latitude, $cities_ro_warehouse->longitude, $user_latitude, $user_longitude, "K");
        //     $tmp_result[] = ['warehouse_id' => $w->id, 'distance' => $distance];
        //   }
        //
        //   //urutkan ke yang terdekat
        //   $result = $this->array_sort($tmp_result, 'distance', SORT_ASC);
        //
        //   //ambil index pertama
        //   $warehouse_id = $result[0]['warehouse_id'];
        //   //get detail warehouse
        //   $warehouse = DB::table('warehouses')->where('id', $warehouse_id)->first();
        //
        //   $client = new Client();
        //
        //   $data = $client->post('https://pro.rajaongkir.com/api/cost',[
        //       'headers' => [
        //         // 'key' => 'a906fd8fc45a816184224df29f246d93'
        //         'key' => '437db99af91a23c64bf1bed279bc4d0f'
        //       ],
        //       'form_params' => [
        //           'origin' => $warehouse->city_id,
        //           'originType' => 'city',
        //           'destination' => $address->subdistrict_id,
        //           'destinationType' => 'subdistrict',
        //           'weight' => $weight,
        //           'courier' => 'jne:tiki:jnt:sicepat'
        //       ]
        //   ]);
        //
        // }else {
        //   $client = new Client();
        //
        //   $data = $client->post('https://pro.rajaongkir.com/api/cost',[
        //       'headers' => [
        //         // 'key' => 'a906fd8fc45a816184224df29f246d93'
        //         'key' => '437db99af91a23c64bf1bed279bc4d0f'
        //       ],
        //       'form_params' => [
        //           'origin' => 457,
        //           'originType' => 'city',
        //           'destination' => $address->subdistrict_id,
        //           'destinationType' => 'subdistrict',
        //           'weight' => $weight,
        //           'courier' => 'jne:tiki:jnt:sicepat'
        //       ]
        //   ]);
        // }

        /**
        *
        * END FLOW CHEKOUT LAMA, OTOMATIS GET DARI GUDANG TERDEKAT BERDASARKAN ALAMAT USER
        *
        **/

        /**
        *
        *  FLOW CHEKOUT BARU
        *
        **/

        if (!$request->has('warehouse_id')) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Gudang tidak ditemukan'
          ], 400);
        }

        $warehouse = DB::table('warehouses')->where('id', $request->warehouse_id)->first();



        $client = new Client();

        $data = $client->post('https://pro.rajaongkir.com/api/cost',[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => $warehouse->city_id,
                'originType' => 'city',
                'destination' => $address->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => 'jne:tiki:jnt:sicepat'
            ]
        ]);

        /**
        *
        * END  FLOW CHEKOUT BARU
        *
        **/
        $res = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $res
        ], 200);
    }

    public function checkProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
            'subdistrict_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400);
        }

        // Get data from cart
        $cartRaws = DB::table('product_carts')
                    ->join('vendor_products', 'vendor_products.id', 'product_carts.vendor_product_id')
                    ->join('categories', 'categories.id', 'vendor_products.category_id')
                    ->select('product_carts.id', 'vendor_products.product_name','product_carts.qty', 'vendor_products.img', 'vendor_products.price', 'vendor_products.weight','categories.cat_name AS category', DB::raw('product_carts.qty * vendor_products.price as total'))
                    ->where('product_carts.deleted_at', null)
                    ->where('vendor_products.deleted_at', null);

        if (auth()->user()) {
            $carts = $cartRaws->where('user_id', auth()->user()->id)->get();
        } else {
            $userToken = DB::table('user_tokens')->where('token', $request->token)->first();
            $carts = $cartRaws->where('token_id', $userToken->id)->get();
        }

        // Get weight
        $weight = 0;
        foreach ($carts as $cart) {
            $weight += $cart->weight;
        }

        // Check if product not found or weight = 0
        if ($weight == 0) {
            $weight = 1;
        }

        $client = new Client();

        // JNE
        $data = $client->post('https://pro.rajaongkir.com/api/cost',[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => 457,
                'originType' => 'city',
                'destination' => $request->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => 'jne:tiki:jnt:sicepat'
            ]
        ]);

        $res = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $res
        ], 200);
    }

    public function checkStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'city_id' => 'required',
            // 'subdistrict_id' => 'required'
            'event_id' => 'required',
            'address_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 422);
        }

        // Check Event
        $exits = DB::table('event_store')->where('id', $request->event_id)->first();
        if (!$exits) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Event tidak ditemukan'
            ], 404);
        }

        // Check address
        $address = DB::table('user_address_store')->where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();
        if (!$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Alamat tidak ditemukan'
            ], 404);
        }

        // Get weight product
        $qty = DB::table('product_cart_store')
                ->where('event_id', $request->event_id)
                ->where('user_id', auth()->user()->id)
                ->first()
                ->qty;

        $berat = DB::table('event_store')
                    ->where('id', $request->event_id)
                    ->get()
                    ->sum('weight_product');

        $weight = $berat * $qty;

        // Check if product not found or weight = 0
        if ($weight == 0) {
            $weight = 1;
        }

        // $client = new Client();
        $client = new \GuzzleHttp\Client(['verify' => false ]);

        $data = $client->post('https://pro.rajaongkir.com/api/cost',[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => 457,
                'originType' => 'city',
                'destination' => $address->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => 'jne:tiki:jnt:sicepat'
            ]
        ]);

        $res = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $res
        ], 200);
    }

    public function wayBill(Request $request)
    {
        try {
            $client = new Client();
            // return $orders->resi;
            $data = $client->post('https://pro.rajaongkir.com/api/waybill',[
                'headers' => [
                  // 'key' => 'a906fd8fc45a816184224df29f246d93'
                  'key' => '437db99af91a23c64bf1bed279bc4d0f'
                ],
                'form_params' => [
                    'waybill' => $request->resi,
                    'courier' => $request->kurir
                ]
            ]);
            $response = json_decode($data->getBody()); //->getContents();
            return response()->json([
              'status' => 'success',
              'status_code' => '01',
              'waybill' => $response->rajaongkir->result
            ], 200);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
            $msg = json_decode($response->getBody()->getContents());

            return response()->json([
                'data' => $msg
            ]);
        }
    }

    public function manifestCheck(Request $request){

      $validator = Validator::make($request->all(), [
          'invoice' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'failed',
              'message' => $validator->errors()
          ], 400);
      }

      /** Check invoice ebook */
      $ebookInvoice = DB::table('orders')->where('invoice', $request->invoice)->orWhere('resi', $request->invoice)->count();
      if($ebookInvoice == 1){

        $orders = DB::table('orders')->where('invoice', $request->invoice)->orWhere('resi', $request->invoice)->first();

        if($orders->resi == null)
        {
          return response()->json([
            'status' => 'success',
            'message' => 'Proses pengemasan'
          ]);
        }
        else{
          $courier = explode("-", $orders->kurir);
          $courier = $courier[0];
          try{
            $client = new Client();
            // return $orders->resi;
            $data = $client->post('https://pro.rajaongkir.com/api/waybill',[
                'headers' => [
                  // 'key' => 'a906fd8fc45a816184224df29f246d93'
                  'key' => '437db99af91a23c64bf1bed279bc4d0f'
                ],
                'form_params' => [
                    'waybill' => $orders->resi,
                    'courier' => $courier
                ]
            ]);
            $response = json_decode($data->getBody()); //->getContents();
            return response()->json([
              'status' => 'success',
              'status_code' => '01',
              'waybill' => $response->rajaongkir->result
            ], 200);
          }
          catch(Exception $e){
            return $e->getBody()->getContents();
          }

        }

      }
      /** Check invoice product */
      $productInvoice = DB::table('order_carts')->where('invoice', $request->invoice)->orWhere('resi', $request->invoice)->count();

      if($productInvoice == 1){

        $orderCart = DB::table('order_carts')->where('invoice', $request->invoice)->orWhere('resi', $request->invoice)->first();
        if($orderCart->resi == null)
        {
          return response()->json([
            'status' => 'success',
            'status_code' => '02',
            'message' => 'proses pengemasan'
          ]);
        }
        else{
          $courier = explode("-", $orderCart->kurir);
          $courier = $courier[0];
          try{
            $client = new Client();
            $data = $client->post('https://pro.rajaongkir.com/api/waybill',[
                'headers' => [
                  // 'key' => 'a906fd8fc45a816184224df29f246d93'
                  'key' => '437db99af91a23c64bf1bed279bc4d0f'
                ],
                'form_params' => [
                    'waybill' => $orderCart->resi,
                    'courier' => $courier
                ]
            ]);
            $response = json_decode($data->getBody()); //->getContents();
            return response()->json([
              'status' => 'success',
              'status_code' => '01',
              'waybill' => $response->rajaongkir->result
            ], 200);
          }
          catch(Exception $e){
            return $e->getBody()->getContents();
          }

        }

      }

      if($ebookInvoice == 0 && $productInvoice == 0){
        return response()->json([
          'status' => 'failed',
          'status_code' => '00',
          'message' => 'invoice atau resi tidak ditemukan'
        ]);
      }

    }

    public function checkOngkir(Request $request){
      $validator = Validator::make($request->all(), [
          // 'city_id' => 'required',
          // 'subdistrict_id' => 'required'
          'invoice' => 'required',
          'address_id' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'failed',
              'message' => $validator->errors()
          ], 400);
      }

      // Check Invoice
      $exits = DB::table('order_carts')->where('invoice', $request->invoice)->first();
      if (!$exits) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Invoice tidak ditemukan'
          ], 400);
      }

      // Check address
      $address = DB::table('user_address')->where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();
      if (!$address) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Alamat tidak ditemukan'
          ], 404);
      }

      // Get weight product
      // $weight = DB::table('order_carts')
      //             ->where('order_carts.invoice', $request->invoice)
      //             ->join('order_cart_details', 'order_carts.id', 'order_cart_details.order_id')
      //             ->join('vendor_products', 'vendor_products.id', 'order_cart_details.vendor_product_id')
      //             ->select(DB::raw('order_cart_details.qty * vendor_products.weight as total_weight'))
      //             ->get()
      //             ->sum('total_weight');
      //
      //
      // // Check if product not found or weight = 0
      // if ($weight == 0) {
      //     $weight = 1;
      // }
      $weight = 1;
      $client = new Client();

      $data = $client->post('https://pro.rajaongkir.com/api/cost',[
          'headers' => [
            // 'key' => 'a906fd8fc45a816184224df29f246d93'
            'key' => '437db99af91a23c64bf1bed279bc4d0f'
          ],
          'form_params' => [
              'origin' => 457,
              'originType' => 'city',
              'destination' => $address->subdistrict_id,
              'destinationType' => 'subdistrict',
              'weight' => $weight,
              'courier' => 'jne:tiki:jnt:sicepat'
          ]
      ]);

      $res = json_decode($data->getBody())->rajaongkir->results;

      return response()->json([
          'status' => 'success',
          'data' => $res
      ], 200);
    }

    public function checkOngkirNew(Request $request){
      $validator = Validator::make($request->all(), [
          // 'city_id' => 'required',
          // 'subdistrict_id' => 'required'
          'invoice' => 'required',
          'address_id' => 'required',
          'warehouse_id' => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'failed',
              'message' => $validator->errors()
          ], 400);
      }

      // Check Invoice
      $exits = DB::table('order_carts')->where('invoice', $request->invoice)->first();
      if (!$exits) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Invoice tidak ditemukan'
          ], 400);
      }

      // Check address
      $address = DB::table('user_address')
                ->where('id', $request->address_id)
                ->where('user_id', auth()->user()->id)
                ->first();
      if (!$address) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Alamat tidak ditemukan'
          ], 404);
      }

      // Get weight product
      $weight = DB::table('order_carts')
                  ->where('order_carts.invoice', $request->invoice)
                  ->join('order_cart_details', 'order_carts.id', 'order_cart_details.order_id')
                  ->join('vendor_products', 'vendor_products.id', 'order_cart_details.vendor_product_id')
                  ->select(DB::raw('order_cart_details.qty * vendor_products.weight as total_weight'))
                  ->get()
                  ->sum('total_weight');


      // Check if product not found or weight = 0
      if ($weight == 0) {
          $weight = 1;
      }
      // $weight = 1;

      /**
      *
      * FLOW CHEKOUT LAMA, OTOMATIS GET DARI GUDANG TERDEKAT BERDASARKAN ALAMAT USER
      *
      **/
      // $check_warehouse = DB::table('warehouses')->where('status', 'confirmed')->where('warehouse_status', 1)->get();
      // if (!$check_warehouse->isEmpty()) {
      //   $cities_ro_user =  DB::table('cities_ro')->where('city_id', $address->city_id)->first();
      //   // cari yang terdekat
      //   $user_latitude = $cities_ro_user->latitude;
      //   $user_longitude = $cities_ro_user->longitude;
      //
      //   $distance = array();
      //
      //   foreach($check_warehouse as $w){
      //     $cities_ro_warehouse =  DB::table('cities_ro')->where('city_id', $w->city_id)->first();
      //     $distance = $this->distance($cities_ro_warehouse->latitude, $cities_ro_warehouse->longitude, $user_latitude, $user_longitude, "K");
      //     $tmp_result[] = ['warehouse_id' => $w->id, 'distance' => $distance];
      //   }
      //
      //   //urutkan ke yang terdekat
      //   $result = $this->array_sort($tmp_result, 'distance', SORT_ASC);
      //
      //   //ambil index pertama
      //   $warehouse_id = $result[0]['warehouse_id'];
      //   //get detail warehouse
      //   $warehouse = DB::table('warehouses')->where('id', $warehouse_id)->first();
      //
      //   $client = new Client();
      //
      //   $data = $client->post('https://pro.rajaongkir.com/api/cost',[
      //       'headers' => [
      //         // 'key' => 'a906fd8fc45a816184224df29f246d93'
      //         'key' => '437db99af91a23c64bf1bed279bc4d0f'
      //       ],
      //       'form_params' => [
      //         'origin' => $warehouse->city_id,
      //           'originType' => 'city',
      //           'destination' => $address->subdistrict_id,
      //           'destinationType' => 'subdistrict',
      //           'weight' => $weight,
      //           'courier' => 'jne:tiki:jnt:sicepat'
      //       ]
      //   ]);
      // }else {
      //   $client = new Client();
      //
      //   $data = $client->post('https://pro.rajaongkir.com/api/cost',[
      //       'headers' => [
      //         // 'key' => 'a906fd8fc45a816184224df29f246d93'
      //         'key' => '437db99af91a23c64bf1bed279bc4d0f'
      //       ],
      //       'form_params' => [
      //           'origin' => 457,
      //           'originType' => 'city',
      //           'destination' => $address->subdistrict_id,
      //           'destinationType' => 'subdistrict',
      //           'weight' => $weight,
      //           'courier' => 'jne:tiki:jnt:sicepat'
      //       ]
      //   ]);
      // }
      /**
      *
      * END FLOW CHEKOUT LAMA, OTOMATIS GET DARI GUDANG TERDEKAT BERDASARKAN ALAMAT USER
      *
      **/


        /**
        *
        * FLOW CHEKOUT BARU
        *
        **/

        $client = new Client();

        $warehouse = DB::table('warehouses')->where('id', $request->warehouse_id)->first();

        $data = $client->post('https://pro.rajaongkir.com/api/cost',[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => $warehouse->city_id,
                'originType' => 'city',
                'destination' => $address->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => 'jne:tiki:jnt:sicepat'
            ]
        ]);

        /**
        *
        * END FLOW CHEKOUT BARU
        *
        **/





      $res = json_decode($data->getBody())->rajaongkir->results;
      $res = collect($res);
      $result = array();
      $result = $res->where('code', 'jne');
      $result[0]->code = "";
      $costs = $result[0]->costs;

      foreach($costs as $key => $value){
        if($value->service == 'OKE'){
          $result[0]->costs[$key]->description = "Ekonomi";
        }
        elseif($value->service == "REG"){
          $result[0]->costs[$key]->description = "Reguler";
        }
        elseif($value->service == "YES"){
          $result[0]->costs[$key]->description = "Next Day";
        }
      }

      return response()->json([
          'status' => 'success',
          'data' => $result
      ], 200);
    }


    //view ongkir per product
    public function viewOngkirProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $validator->errors()
            ], 400);
        }


        // Check address
        $address = DB::table('users_address')->where('id', $request->address_id)->where('user_id', auth()->user()->id)->first();
        if (!$address) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Alamat tidak ditemukan'
            ], 404);
        }

        $weight = 1;

        $client = new Client();

        $data = $client->post('https://pro.rajaongkir.com/api/cost',[
            'headers' => [
              // 'key' => 'a906fd8fc45a816184224df29f246d93'
              'key' => '437db99af91a23c64bf1bed279bc4d0f'
            ],
            'form_params' => [
                'origin' => 6312,
                'originType' => 'subdistrict',
                'destination' => $address->subdistrict_id,
                'destinationType' => 'subdistrict',
                'weight' => $weight,
                'courier' => 'jne:sicepat'
            ]
        ]);

        $res = json_decode($data->getBody())->rajaongkir->results;

        return response()->json([
            'status' => 'success',
            'data' => $res
        ], 200);
    }

    public function checkOngkirByCart(Request $request){
      $validator = Validator::make($request->all(), [
          'cart_id' => 'required',
          'address_id' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'failed',
              'message' => $validator->errors()
          ], 422);
      }

      // Check Cart
      $exist = DB::table('product_carts')->whereIn('id', $request->cart_id)->get();

      if ($exist->isEmpty()) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Produk pada keranjang tidak ditemukan'
          ], 400);
      }

      // Check address
      $address = DB::table('user_address_marketplace')
                ->where('id', $request->address_id)
                ->first();
      if (!$address) {
          return response()->json([
              'status' => 'failed',
              'message' => 'Alamat tidak ditemukan'
          ], 404);
      }

      // Get weight product
      $getProduct = DB::table('product_carts')
                  ->whereIn('product_carts.id', $request->cart_id)
                  ->join('vendor_products', 'vendor_products.id', 'product_carts.vendor_product_id')
                  ->select('product_carts.vendor_product_id','vendor_products.weight','product_carts.qty','vendor_products.free_shipping')
                  ->get();

      /**
      * Calculate
      */

      $weight = 0;
      foreach($getProduct as $product){
        if ($product->free_shipping == true) {
          $weight += 0;
        } else {
          $weight += $product->weight * $product->qty;
        }
      }

      // Check if product not found or weight = 0
      if ($weight == 0) {
          $weight = 1;
      }

      //find matches text at table city
      $compare = DB::table('cities_ro')->get();
      foreach ($compare as $row) {
        $hasil = $this->compareStrings($address->city,$row->city_name);
        $result[] = array(
          'id' => $row->id,
          'city_name' => $row->city_name,
          'result' => $hasil
        );
      }
      $arr = array_column($result, 'result');

      array_multisort($arr, SORT_DESC, $result);

      // dd($result);
      $getId = $result[0]['id'];
      //End find matches text at table city

      $client = new Client();

      $data = $client->post('https://pro.rajaongkir.com/api/cost',[
          'headers' => [
            'key' => '437db99af91a23c64bf1bed279bc4d0f'
          ],
          'form_params' => [
              'origin' => 457,
              'originType' => 'city',
              'destination' => $getId,
              'destinationType' => 'city',
              'weight' => $weight,
              'courier' => 'jne:tiki:jnt:sicepat'
          ]
      ]);

      $res = json_decode($data->getBody())->rajaongkir->results;
      $res = collect($res);
      $result = array();
      $result = $res->where('code', 'jne');
      // $result[0]->code = "";
      $costs = $result[0]->costs;

      foreach($costs as $key => $value){
        if($value->service == 'OKE'){
          $result[0]->costs[$key]->description = "Ekonomi";
        }
        elseif($value->service == "REG"){
          $result[0]->costs[$key]->description = "Reguler";
        }
        elseif($value->service == "YES"){
          $result[0]->costs[$key]->description = "Next Day";
        }
      }

      return response()->json([
          'status' => 'success',
          'data' => $result
      ], 200);
    }

    public function checkPaketKelas(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'city_id' => 'required',
          'paket_kelas_id' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'failed',
              'message' => $validator->errors()
          ], 422);
      }

      // Get weight product
      $weight = DB::table('types_warisan')
                  ->where('types_warisan.id', $request->paket_kelas_id)
                  ->join('types_product_warisan', 'types_product_warisan.type_warisan_id', 'types_warisan.id')
                  ->get()
                  ->sum('weight_product');

      // Check if product not found or weight = 0
      if ($weight == 0) {
          $weight = 1;
      }

      $client = new Client();

      $data = $client->post('https://pro.rajaongkir.com/api/cost',[
          'headers' => [
            'key' => '437db99af91a23c64bf1bed279bc4d0f'
          ],
          'form_params' => [
              'origin' => 457,
              'originType' => 'city',
              'destination' =>  $request->city_id,
              'destinationType' => 'city',
              'weight' => $weight,
              'courier' => 'jne:tiki:jnt:sicepat'
          ]
      ]);

      $res = json_decode($data->getBody())->rajaongkir->results;
      $res = collect($res);
      $result = array();
      $result = $res->where('code', 'jne');
      // $result[0]->code = "";
      $costs = $result[0]->costs;

      foreach($costs as $key => $value){
        if($value->service == 'OKE'){
          $result[0]->costs[$key]->description = "Ekonomi";
        }
        elseif($value->service == "REG"){
          $result[0]->costs[$key]->description = "Reguler";
        }
        elseif($value->service == "YES"){
          $result[0]->costs[$key]->description = "Next Day";
        }
      }
      // dd($result[0]->code);
      $data = [
        'code' => $result[0]->code,
        'name' => $result[0]->name,
        'costs' => $result[0]->costs[0],
      ];
      return response()->json([
          'status' => 'success',
          'data' => $data
      ], 200);
    }

    public function checkProductOngkir(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'city_id' => 'required',
          'produk' => 'required'
      ]);

      if ($validator->fails()) {
          return response()->json([
              'status' => 'failed',
              'message' => $validator->errors()
          ], 422);
      }


        $weight = 0;
        foreach ($request->produk as $c) {
            // Count total product price
            $product = DB::table('vendor_products')->where('slug', $c['slug'])->first();
            $weight += $product->weight * $c['qty'];
        }

        // dd($weight);
      /**
      * Calculate
      */
      // Check if product not found or weight = 0
      if ($weight == 0) {
          $weight = 1;
      }


      $client = new Client();

      $data = $client->post('https://pro.rajaongkir.com/api/cost',[
          'headers' => [
            'key' => '437db99af91a23c64bf1bed279bc4d0f'
          ],
          'form_params' => [
              'origin' => 457,
              'originType' => 'city',
              'destination' =>  $request->city_id,
              'destinationType' => 'city',
              'weight' => $weight,
              'courier' => 'jne:tiki:jnt:sicepat'
          ]
      ]);

      $res = json_decode($data->getBody())->rajaongkir->results;
      $res = collect($res);
      $result = array();
      $result = $res->where('code', 'jne');
      // $result[0]->code = "";
      $costs = $result[0]->costs;

      foreach($costs as $key => $value){
        if($value->service == 'OKE'){
          $result[0]->costs[$key]->description = "Ekonomi";
        }
        elseif($value->service == "REG"){
          $result[0]->costs[$key]->description = "Reguler";
        }
        elseif($value->service == "YES"){
          $result[0]->costs[$key]->description = "Next Day";
        }
      }
      // dd($result[0]->code);
      $data = [
        'code' => $result[0]->code,
        'name' => $result[0]->name,
        'costs' => $result[0]->costs[0],
      ];
      return response()->json([
          'status' => 'success',
          'data' => $data
      ], 200);
    }

    public function ongkirByAddressId($cart_id, $address_id, $kurir_service)
    {
      // $cart_id = $request->cart_id;
      // $address_id = $request->address_id;
      // $kurir_service = $request->kurir_service;
      // Get weight product
      $getProduct = DB::table('product_carts')
                  ->whereIn('product_carts.id', $cart_id)
                  ->join('vendor_products', 'vendor_products.id', 'product_carts.vendor_product_id')
                  ->select('product_carts.vendor_product_id','vendor_products.weight','product_carts.qty','vendor_products.free_shipping')
                  ->get();
      $address = DB::table('user_address_marketplace')
                ->where('id', $address_id)
                ->first();
      /**
      * Calculate
      */

      $weight = 0;
      foreach($getProduct as $product){
        if ($product->free_shipping == true) {
          $weight += 0;
        } else {
          $weight += $product->weight * $product->qty;
        }
      }

      // Check if product not found or weight = 0
      if ($weight == 0) {
          $weight = 1;
      }

      //find matches text at table city
      $compare = DB::table('cities_ro')->get();
      foreach ($compare as $row) {
        $hasil = $this->compareStrings(strtolower($address->city),strtolower($row->city_name));
        $result[] = array(
          'id' => $row->id,
          'city_name' => $row->city_name,
          'zipcode' => $row->postal_code,
          'result' => $hasil
        );
      }
      $arr = array_column($result, 'result');

      array_multisort($arr, SORT_DESC, $result);

      // dd($result);
      $getId = $result[0]['id'];
      $zipcode = $result[0]['zipcode'];
      //End find matches text at table city

      $client = new Client();

      $data = $client->post('https://pro.rajaongkir.com/api/cost',[
          'headers' => [
            'key' => '437db99af91a23c64bf1bed279bc4d0f'
          ],
          'form_params' => [
              'origin' => 457,
              'originType' => 'city',
              'destination' => $getId,
              'destinationType' => 'city',
              'weight' => $weight,
              'courier' => 'jne:tiki:jnt:sicepat'
          ]
      ]);

      $res = json_decode($data->getBody())->rajaongkir->results;
      $res = collect($res);
      $tmp_array1 = array();
      $tmp_array1 = $res->where('code', 'jne');
      // dd($costs);
      $costs = $tmp_array1[0]->costs;
      foreach($costs as $row){
          $tmp_collection[] =  (object) array(
              'service' => $row->service,
              'description' => $row->description,
              'value' => $row->cost[0]->value,
              'etd' => $row->cost[0]->etd
          );
      }
      $result = collect($tmp_collection);
      // dd($result);
      $result = $result->where('service', $kurir_service)->first();
      $resData = array('ongkir' => $result->value, 'zipcode'=> $zipcode);
      // dd($ongkir);
      return $resData;
    }

    public function ongkirWarehouseProduct(Request $request)
    {

      //get gudang by user id
      $warehouse = DB::table('warehouses')->where('user_id', auth()->user()->id)->first();

      $total_weight = 0;
      foreach ($request->product as $c) {
          // Count total product price
          $product = DB::table('vendor_products')
                      ->where('sku', $c['sku'])
                      ->where('main_product', 1)
                      ->where('deleted_at', null)
                      ->where('status', 1)
                      ->first();

          if ($product) {

            $total_weight += $product->weight * $c['qty'];

          }else {
            $weight = DB::table('types_warisan')
                        ->where('sku', $c['sku'])
                        ->join('types_product_warisan', 'types_product_warisan.type_warisan_id', 'types_warisan.id')
                        ->get()
                        ->sum('weight_product');
            $total_weight += $weight;
          }

      }//endforeach


      $client = new Client();

      $data = $client->post('https://pro.rajaongkir.com/api/cost',[
          'headers' => [
            'key' => '437db99af91a23c64bf1bed279bc4d0f'
          ],
          'form_params' => [
              'origin' => 457,
              'originType' => 'city',
              'destination' => $warehouse->subsdistrict_id,
              'destinationType' => 'subdistrict',
              'weight' => $total_weight,
              'courier' => 'sentral'
          ]
      ]);


      $res = json_decode($data->getBody())->rajaongkir->results;

      return response()->json([
          'status' => 'success',
          'data' => $res
      ], 200);

    }

    public function compareStrings($s1, $s2) {
        //one is empty, so no result
        if (strlen($s1)==0 || strlen($s2)==0) {
            return 0;
        }

        //replace none alphanumeric charactors
        //i left - in case its used to combine words
        $s1clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s1);
        $s2clean = preg_replace("/[^A-Za-z0-9-]/", ' ', $s2);

        //remove double spaces
        while (strpos($s1clean, "  ")!==false) {
            $s1clean = str_replace("  ", " ", $s1clean);
        }
        while (strpos($s2clean, "  ")!==false) {
            $s2clean = str_replace("  ", " ", $s2clean);
        }

        //create arrays
        $ar1 = explode(" ",$s1clean);
        $ar2 = explode(" ",$s2clean);
        $l1 = count($ar1);
        $l2 = count($ar2);

        //flip the arrays if needed so ar1 is always largest.
        if ($l2>$l1) {
            $t = $ar2;
            $ar2 = $ar1;
            $ar1 = $t;
        }

        //flip array 2, to make the words the keys
        $ar2 = array_flip($ar2);


        $maxwords = max($l1, $l2);
        $matches = 0;

        //find matching words
        foreach($ar1 as $word) {
            if (array_key_exists($word, $ar2))
                $matches++;
        }

        return ($matches / $maxwords) * 100;
        }

        public function array_sort($array, $on, $order=SORT_ASC)
        {
            $new_array = array();
            $sortable_array = array();

            if (count($array) > 0) {
                foreach ($array as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $k2 => $v2) {
                            if ($k2 == $on) {
                                $sortable_array[$k] = $v2;
                            }
                        }
                    } else {
                        $sortable_array[$k] = $v;
                    }
                }

                switch ($order) {
                    case SORT_ASC:
                        asort($sortable_array);
                    break;
                    case SORT_DESC:
                        arsort($sortable_array);
                    break;
                }

                foreach ($sortable_array as $k => $v) {
                    array_push($new_array, $array[$k]);
                }
            }

            return $new_array;
    }

    public function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
      return 0;
    }
    else {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);

      if ($unit == "K") {
        return ($miles * 1.609344);
      } else if ($unit == "N") {
        return ($miles * 0.8684);
      } else {
        return $miles;
      }
    }
  }
}
