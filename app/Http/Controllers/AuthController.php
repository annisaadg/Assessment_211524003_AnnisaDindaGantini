<?php

namespace App\Http\Controllers;

use App\Models\KasirModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('login');
    }

    public function login(Request $request){
        $checkUser = KasirModel::where(['username' => $request->username])->first();

        if ($checkUser) {
            if ($checkUser->is_active == 1) {
                if (Auth::guard('kasir')->attempt(['username' => $request->username, 'password' => $request->password])) {
                    $result['status'] = true;
                    $result['message'] = "Success";
                } else {
                    $result['status'] = false;
                    $result['message'] = "Incorrect Username or Password.";
                }
            } else {
                $result['status'] = false;
                $result['message'] = 'Your account is inactive, please contact administrator.';
            }
        } else {
            $result['status'] = false;
            $result['message'] = 'User not found.';
        }

        return $result;
    }

    public function logout()
    {
        if (Auth::guard('kasir')->check()) {
            Auth::guard('kasir')->logout();
        }
        return redirect('/');
    }
}
