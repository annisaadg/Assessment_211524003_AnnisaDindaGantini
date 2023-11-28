<?php

namespace App\Http\Controllers;

use App\Models\TenantModel;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index() {
        $data['list'] = TenantModel::where(['is_deleted' => 0])->get();
        return view('Tenant.index', $data);
    }

    public function insert(Request $request) {
        $insert['code'] = $request->code;
        $insert['name'] = $request->name;
        $insert['phone_number'] = $request->phone_number;
        $insert['is_active'] = $request->is_active;

        if (TenantModel::create($insert)) {
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
        $getData = TenantModel::where(['id' => $id])->first();

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
        $getData = TenantModel::where(['id' => $id])->first();

        if ($getData) {
            $getData->name = $request->name;
            $getData->code = $request->code;
            $getData->phone_number = $request->phone_number;
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
}
