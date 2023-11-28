<?php

namespace App\Http\Controllers;

use App\Models\KasirModel;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index() {
        $data['list'] = KasirModel::where(['is_deleted' => 0])->get();
        return view('Kasir.index', $data);
    }

    public function insert(Request $request) {
        $insert['code'] = $request->code;
        $insert['fullname'] = $request->fullname;
        $insert['phone_number'] = $request->phone_number;
        $insert['is_active'] = $request->is_active;
        $insert['username'] = $request->username;
        $insert['password'] = bcrypt($request->password);

        if (KasirModel::create($insert)) {
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
        $getData = KasirModel::where(['id' => $id])->first();

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
        $getData = KasirModel::where(['id' => $id])->first();

        if ($getData) {
            $getData->fullname = $request->fullname;
            $getData->code = $request->code;
            $getData->phone_number = $request->phone_number;
            $getData->username = $request->username;
            if ($request->password) {
                $getData->password = bcrypt($request->password);
            }
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
