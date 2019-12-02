<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LaravueController extends Controller
{
    public function index()
    {
        return view('laravue');
    }

    public function success(Request $request)
    {
        $email = \Crypt::decrypt($request->email); 
        User::where('email','=',$email)->update(['is_active'=>1]);
        return view()->make('web.mail.success');
    }

    function forgotPassword() {
        if(request()->method() == 'GET') {
            return view('web.mail.form_forgotpass');
        } else if (request()->method() == 'POST') {
            try {
                $code = request()->input('encrytCode', null);
                $email = \Crypt::decrypt($code);
                $user = User::where('email', '=', $email)->first();
                if ($user) {
                    $validator = \Validator::make(request()->all(), [
                        'password' => 'required|min:6|max:30|required_with:password_confirm|same:password_confirm',
                        'password_confirm' => 'required',
                    ], [
                        'min' => 'Mật khẩu tối thiểu 6 số',
                        'max' => 'Mật khẩu tối đa 30 số',
                        'required' => 'Bắt buộc nhập',
                        'same' => 'Mật khẩu không khớp'
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    $user->password = \Hash::make(request()->password);
                    $user->save();
                    return view('web.mail.forgotsuccess');
                } else {
                    return redirect()->back()->withErrors(['error' => 'Email không đúng']);
                }
            } catch(\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Server lỗi']);
            }
        }
    }
}
