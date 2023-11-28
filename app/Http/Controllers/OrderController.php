<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use App\Models\TenantModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $data['list'] = OrderModel::with('kasir')->get();
        return view('Orders.index', $data);
    }

    public function add() {
        $data['tenant'] = TenantModel::where(['is_active' => 1, 'is_deleted' => 0])->get();
        return view('Orders.add', $data);
    }

    public function insert(Request $request) {
        $data = $request->data;
        $grandTotal = $request->grandTotal;

        $insert['transaction_id'] = 'TR-'.time();
        $insert['id_kasir'] = Helper::getUser()->id;
        $insert['grand_total'] = $grandTotal;

        $order = OrderModel::create($insert);

        if ($order) {
            foreach ($data as $key => $value) {
                $insertDetail['id_barang'] = $value['menu']['id'];
                $insertDetail['qty'] = $value['qty'];
                $insertDetail['id_order'] = $order->id;
    
                OrderDetailModel::create($insertDetail);
            }

            $result['status'] = true;
            $result['message'] = 'Success';
        } else {
            $result['status'] = false;
            $result['message'] = 'Failed';
        }

        return $result;
    }

    public function detail($id){
        $data = OrderModel::where(['id' => $id])->with('kasir')->first();
        if ($data) {
            $data->detail = OrderDetailModel::where(['id_order' => $data->id])->with('barang')->get();

            $result['status'] = true;
            $result['message'] = 'Success';
            $result['data'] = $data;
        } else {
            $result['status'] = false;
            $result['message'] = 'Failed';
        }
        
        return $result;
    }
}
