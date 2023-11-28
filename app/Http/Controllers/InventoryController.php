<?php

namespace App\Http\Controllers;

use App\Models\InventoryModel;
use App\Models\TenantModel;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index() {
        $data['list'] = InventoryModel::where(['is_deleted' => 0])->with('tenant')->get();
        $data['tenant'] = TenantModel::where(['is_deleted' => 0])->get();
        return view('Inventory.index', $data);
    }

    public function insert(Request $request) {
        $insert['code'] = $request->code;
        $insert['name'] = $request->name;
        $insert['unit'] = $request->unit;
        $insert['price'] = $request->price;
        $insert['id_tenant'] = $request->id_tenant;
        $insert['is_active'] = $request->is_active;

        if (InventoryModel::create($insert)) {
            $result['status'] = true;
            $result['message'] = 'Success';
        } else {
            $result['status'] = false;
            $result['message'] = 'Failed';
        }

        return $result;
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $getData = InventoryModel::where(['id' => $id])->first();

        if ($getData) {
            $getData->is_deleted = 1;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Success';
                $result['data'] = null;
            } else {
                $result['status'] = false;
                $result['message'] = 'Failed';
                $result['data'] = null;
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data not found';
            $result['data'] = null;
        }

        return $result;
    }

    public function update(Request $request) {
        $id = $request->id;
        $getData = InventoryModel::where(['id' => $id])->first();

        if ($getData) {
            $getData->name = $request->name;
            $getData->code = $request->code;
            $getData->unit = $request->unit;
            $getData->price = $request->price;
            $getData->stock = $request->stock;
            $getData->id_tenant = $request->id_tenant;
            $getData->is_active = $request->is_active;

            if ($getData->save()) {
                $result['status'] = true;
                $result['message'] = 'Success';
                $result['data'] = null;
            } else {
                $result['status'] = false;
                $result['message'] = 'failed';
                $result['data'] = null;
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'Data not found';
            $result['data'] = null;
        }

        return $result;
    }

    public function getMenu($idTenant) {
        $getData = InventoryModel::where(['id_tenant' => $idTenant, 'is_active' => 1, 'is_deleted' => 0])->get();

        if ($getData) {
            $result['status'] = true;
            $result['message'] = 'Success';
            $result['data'] = $getData;
        } else {
            $result['status'] = false;
            $result['message'] = 'Data not found';
        }
        
        return $result;
    }
}
