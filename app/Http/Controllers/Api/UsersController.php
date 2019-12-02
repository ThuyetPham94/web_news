<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\User;
use App\Models\LOG;
use App\Http\Controllers\Utils\FileManage;
use App\Http\Controllers\Utils\WordsUtil;
use App\Http\Services\UserService;
use App\Http\Services\FacebookService;
use App\Models\Configuration;
use App\Models\ServiceManagement;
use App\Models\Transaction;
use Hash;
use Config;
use Auth;
use Mail;
use JWTAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersController extends ApiBaseController
{

    public function __construct(UserService $userService, FacebookService $facebookService){
        $this->userService = $userService;
        $this->facebookService = $facebookService;
    }

    public function login(Request $request) {
        try
        {
            $config = Configuration::first();
            $user = collect([]);
            $email = $request->input('email', '');
            $first_name = $request->input('first_name', '');
            $last_name = $request->input('sur_and_last_name', '');
            $photo = $request->input('photo', '');
            $facebook_id = 0;
            if($request->login_type == 1)
            {
                if (!Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password , 'is_admin' => 0])) {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.wrongPhoneOrPassword',$request->language_type)));
                }
                else
                {
                    $user = Auth::user();
                    $result = Carbon::parse($user->expire_time)->gt(Carbon::now());
                    if(!$result){
                        return $this->returnError(502, Config::get($this->getConstantMessage('constants.expire', $request->language_type)));
                    }
                }
            }
            else if($request->login_type == 2)
            {
                $facebook = $this->facebookService->getProfile($request->access_token);
                if($request->access_token == null || $request->access_token == "" || $facebook == null)
                {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.loginFailed',$request->language_type)));
                }
                $user = User::where('facebook_id','=', $facebook['id'])->first();
                $first_name = $facebook['first_name'];
                $last_name = $facebook['last_name'];
                $email = $facebook['email'];
                $photo = $facebook['picture'];
                $facebook_id = $facebook['id'];
                $result = Carbon::parse($user->expire_time)->gt(Carbon::now());
                if(!$result){
                    return $this->returnError(502, Config::get($this->getConstantMessage('constants.expire', $request->language_type)));
                }
            }
            else if($request->login_type == 3)
            {
                if (!Auth::attempt(['email' => $request->email, 'password' => $request->password , 'is_admin' => 0])) {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.wrongEmailOrPass',$request->language_type)));
                }
                else
                {
                    $user = Auth::user();
                    $result = Carbon::parse($user->expire_time)->gt(Carbon::now());
                    if(!$result){
                        return $this->returnError(502, Config::get($this->getConstantMessage('constants.expire', $request->language_type)));
                    }
                }
            }
            if($user) {
                if($user->is_active == 0)
                {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.accountIsInactive',$request->language_type)));
                }
                if($user->is_suspend == 1)
                {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.accountIsSuspend',$request->language_type)));
                }
                Auth::login($user, true);
                $users = Auth::user();
                $token = JWTAuth::fromUser($users);
                $users->token_firebase = $request->token_firebase;
                $users->device_type = $request->device_type;
                $users->login_type = $request->login_type;
                if($users -> save())
                {
                    $users->JwtToken = $token;
                }
                $users->photo = FileManage::getPhotoURL($users->photo);
                $users->isVip = WordsUtil::isVip($users->id);
                $users->how_to_use = $config->how_to_use; // nene
                $users->FAQ = $config->FAQ;
                $users->contact = $config->contact;
                return $this->returnSuccess(Config::get($this->getConstantMessage('constants.loginSuccess',$request->language_type)),$users);
            }
            else
            {
                $user = new User();
                $user->email = $email;
                $user->facebook_id = $facebook_id;
                $user->token_firebase = $request->token_firebase;
                $user->photo = $photo;
                $user->first_name = $first_name;
                $user->sur_and_last_name = $last_name;
                $user->phone_number = $request->input('phone_number', 0);
                $user->device_type = $request->device_type;
                $user->is_active = 1;
                $user->is_suspend = 0;
                $user->is_admin = 0;
                $dateNow = new \Carbon\Carbon();
                $dateNow = $dateNow->addDays(30);
                $user->expire_time = $dateNow;
                $user->login_type = $request->login_type;
                if($user->save()){
                    Auth::login($user, true);
                    $users = Auth::user();
                    $token = JWTAuth::fromUser($user);
                    $users->ApiToken = $users->remember_token;
                    $user->photo = FileManage::getPhotoURL($user->photo);
                    $users->JwtToken = $token;
                    $users->how_to_use = $config->how_to_use; // nene
                    $users->FAQ = $config->FAQ;
                    $users->contact = $config->contact;
                    $users->isVip = WordsUtil::isVip($users->id);
                    return $this->returnSuccess(Config::get($this->getConstantMessage('constants.loginSuccess',$request->language_type)),$users);
                }else{
                    $this->returnError(404, Config::get('constants.error502'));
                }
            }
        }
        catch (\Exception $e)
        {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }

    public function forgotPassword(Request $request){
        try {
            $user = $this->userService->getUserByName('email', $request->email);
            $result = Carbon::parse($user->expire_time)->gt(Carbon::now());
            if(!$result){
                return $this->returnError(502, Config::get($this->getConstantMessage('constants.expire', $request->language_type)));
            }
            if($user){
                $encrytCode = \Crypt::encrypt($request->email);
                try{
                    Mail::send('web.mail.forgotpassword', ['encrytCode' => $encrytCode], function ($m) use ($request) {
                        $m->to($request->email)->subject('Change Your password');
                    });
                } catch(\Exception $e){}
                return $this->returnSuccess(Config::get($this->getConstantMessage('constants.sendEmailSuccess',$request->language_type)));
            }else{
                return $this->returnError(404, Config::get($this->getConstantMessage('constants.sendEmailFail',$request->language_type)));
            }
        } catch (\Exception $e) {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }

    public function register(Request $request) {
        try
        {
            $config = Configuration::first();
            $verifyEmail = User::where('email', $request->email)->first();
            if($request->email == null || $request->email == "")
            {
                return $this->returnError(404, Config::get($this->getConstantMessage('constants.emailIncorrect',$request->language_type)));
            }
            else if($request->phone_number == null || $request->email == "")
            {
                if($verifyEmail)
                {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.emailExists',$request->language_type)));
                }
            }
            else
            {
                if($verifyEmail)
                {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.emailExists',$request->language_type)));
                }
                $verifyUser = User::where('phone_number', $request->phone_number)->first();
                if($verifyUser)
                {
                    return $this->returnError(404, Config::get($this->getConstantMessage('constants.phoneExists',$request->language_type)));
                }
            }
            $user = new User();
            $token = JWTAuth::fromUser($user);
            $user->email = $request->email;
            $user->phone_number = $request->phone_number;
            $user->facebook_id = '';
            $user->token_firebase = $request->token_firebase;
            $user->password = Hash::make($request->password);
            $user->first_name = $request->first_name;
            $user->sur_and_last_name = $request->sur_and_last_name;
            $user->device_type = $request->device_type;
            $user->is_active = 0;
            $user->is_suspend = 0;
            $user->is_admin = 0;
            $dateNow = new \Carbon\Carbon();
            $dateNow = $dateNow->addDays(30);
            $user->expire_time = $dateNow->format("Y-m-d H:i:s");
            $user->login_type = 3;
            if($request->hasFile("photo"))
            {
                $user->photo = FileManage::saveFile($request->file("photo"));
            }
            if($user->save()){
                $encrytCode = \Crypt::encrypt($request->email);
                try {
                    Mail::send(['html'=>'web.mail.active'], array('email'=> $encrytCode,'name'=>$request->first_name,'email_new'=>$request->email), function ($message) use($request){
                        $message->to($request->email, 'Visitor')->subject('Welcome to VAPP');
                    });
                } catch (Exception $e) {
                    LOG::logRequest($e);
                    return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
                }

                Auth::login($user, true);
                $users = Auth::user();
                $users->JwtToken = $token;
                $users->ApiToken = $users->remember_token;
                $users->photo = FileManage::getPhotoURL($users->photo);
                $users->how_to_use = $config->how_to_use; // nene
                $users->FAQ = $config->FAQ;
                $users->contact = $config->contact;
                $users->isVip = WordsUtil::isVip($users->id);
                $users->text_size = 0;
                $users->introduction = null;
                $users->number_of_images_to_display = 3;
                $users->display_image_and_text_type = 1;
                $users->display_text_type = 1;
                $users->display_list_type = 1;
                $users->expire_time = $dateNow;
                $users->language_type = 1;
                return $this->returnSuccess(Config::get($this->getConstantMessage('constants.registerSuccessful',$request->language_type)),$user);
            }else{
                return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
            }
        }
        catch (\Exception $e)
        {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }

    public function getUserInformation(Request $request){
        try {
            $user = User::find($request->UserID);
            $config = Configuration::first(); // nen dung ham nay, neu ko tìm thay thì no khoi tạo 1 doi tuong rỗng của Configuration
            $user->photo = FileManage::getPhotoURL($user->photo);
            $user->introduction = FileManage::getAudioURL($user->introduction);
            $user->JwtToken = $request->JwtToken;
            $user->how_to_use = $config->how_to_use; // nene
            $user->FAQ = $config->FAQ;
            $user->contact = $config->contact;
            $user->isVip = WordsUtil::isVip($user->id);
            return $this->returnSuccess("",$user);
        } catch (\Exception $e) {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }

    public function updateUserInformation(Request $request){
        try {
            $user = User::find($request->UserID);
            if($request->photo_url != null && $request->photo_url != "")
            {
                $user->photo = FileManage::saveFile(null, 1, $request->photo_url);
            }
            else
            {
                $user->photo = FileManage::saveFile($request->file("photo"), 1, "");
            }
            if($request->introduction_url != null && $request->introduction_url != "")
            {
                $user->introduction = FileManage::saveFile(null, 1, $request->introduction_url);
            }
            else
            {
                $user->introduction = FileManage::saveFile($request->file("introduction"), 2, "");
            }            
            $user->number_of_images_to_display = $request->number_of_images_to_display;
            $user->display_image_and_text_type = $request->display_image_and_text_type;
            $user->display_text_type = $request->display_text_type;
            $user->display_list_type = $request->display_list_type;
            $user->language_type = $request->language_type;
            $user->text_size = $request->text_size;
            $user->save();
            $config = Configuration::first();
            $user->photo = FileManage::getPhotoURL($user->photo);
            $user->introduction = FileManage::getAudioURL($user->introduction);
            $user->JwtToken = $request->JwtToken;
            $user->how_to_use = $config->how_to_use; // nene
            $user->FAQ = $config->FAQ;
            $user->contact = $config->contact;
            $user->isVip = WordsUtil::isVip($user->id);
            return $this->returnSuccess(Config::get($this->getConstantMessage('constants.updateInforSuccess',$request->language_type)),$user);
        } catch (\Exception $e) {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }

    public function getAllServices(Request $request){
        try {
            $language = $this->getLanguage($request->language_type);
            $services = ServiceManagement::get();
            foreach ($services as $value) {
                $value->descriptions = $value['description_'.$language];
                $value->discount = $value['discount_'.$language] == null ? "" : $value['discount_'.$language];
            }
            $output = array();
            $output['services'] = $services;            
            return $this->returnSuccess("",$output);
        } catch (\Exception $e) {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }

    public function updateUserAccountAfterPayment(Request $request){
        try {     
            DB::beginTransaction();   
            $message = Config::get($this->getConstantMessage('constants.paymentSuccess',$request->language_type));            
            $service = ServiceManagement::find($request->service_id);
            $user = User::find($request->UserID);    
            $dateNow = new \Carbon\Carbon();            
            $expireDate = Carbon::parse($user->expire_time);    
            $date;     
            if($dateNow > $expireDate)
            {
                $date = $dateNow;
            }
            else
            {
                $date = $expireDate;
            }
            $date->addMonths($service->number_of_months);
            $user->expire_time = $date;
            if($request->payment_type == 2 || $request->payment_type == 3)
            {
                $user->save();  
            }               
            $transaction = new Transaction();
            $transaction['user_id'] = $request->UserID;
            $transaction['service_management_id'] = $request->service_id;
            if($request->hasFile("photo"))
            {
                $transaction['photo'] = FileManage::saveFile($request->file("photo"));
            }
            if($request->payment_type == 1)
            {
                $transaction['is_active'] = 0;
                $message = Config::get($this->getConstantMessage('constants.paymentConfirm',$request->language_type));            
            } 
            else
            {
                $transaction['is_active'] = 1;
            }
            $transaction['payment_type'] = $request->payment_type;
            $transaction->save();
            DB::commit();
            return $this->returnSuccess($message);
        } catch (\Exception $e) {
            LOG::logRequest($e);
            return $this->returnError(502, Config::get($this->getConstantMessage('constants.error502',$request->language_type)));
        }
    }
}
