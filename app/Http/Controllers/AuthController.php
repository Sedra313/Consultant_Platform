<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use File;
use App\Models\Expert;
use App\Models\User;
use App\Models\BusinessTime;

class AuthController extends Controller
{
    public function User_Register(Request $request)
    {
    #Check the validations rules
       $Rules = Validator::make($request->all() , 
        [
           'name' => ['required','string'] ,
           'email'=> ['required','unique:experts,email','max:255'] ,
           'password' =>['required','string','min:8'],

        ]
          );

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::query()->create($input);
        $accessToken = $user->createToken('MyAccessToken',['user'])->accessToken;

        return response()->json([
           'user' => $user,
           'access_Token' => $accessToken
       ]);

    }

    public function User_Login(Request $request):JsonResponse
    {
        $request -> validate([
          'email' => ['required','email'],
          'password' =>['required','string'],
        ]);
        $credentials = request(['email', 'password']);

        #authinicate the user
        if(auth()->guard('user')->attempt($request -> only(['email', 'password']))) {
            config(['auth.guards.api.provider' => 'user']);
               $user = User::query()->select('users.*')->find(auth()->guard('user')->user()->id);
               $success =  $user;
               $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 
               return response()->json([$success, 200,'Success'=>'Logged in successfully']);
           }else{ 
               return response()->json(['error' => ['Email or Password are Wrong.']], 401);
        }
    }
    public function User_Logout(): JsonResponse
    {
        Auth::guard('user-api')->user()->token()->revoke();
        return response()->json(['success'=>'Logged out successfully']);
    }


     public function Expert_Register(Request $request) : JsonResponse
    {
    #Check the validations rules
       $request->validate([
            'email'=> ['required','max:255','unique:experts,email'] ,
            'name' => ['required','string'] ,
            'password' =>['required','string','min:8'],
           // 'password_confirmation' => ['required_with:password|same:password|min:8']

        ]);

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $expert = Expert::query()->create($input);
        $accessToken = $expert->createToken('MyApp',['user'])->accessToken;

        return response()->json([
           'expert' => $expert,
           'access_Token' => $accessToken
       ]);

  
}

   public function Expert_Update(Request $request)
    {   
        #Check the validations rules
       $Rules = Validator::make($request->all() , [
            //'profile_image'=> ['image|mimes:jpg,png,jpeg,gif,svg|max:2048'] ,
            'category_id' => ['required'] ,
            'phone' => ['required','string','unique:experts,phone'] ,
            'address' =>['required','string','max:255'],
            'workspace_name' => ['required','string','max:255'],
            'years_of_experience' => ['required','string'],
            'category'=>['required'],
            'specialization'=>['required'],
            'description'=>['required','string']
        ]);

       if ($Rules -> fails()) {
            return response() -> json([
                'errors' => $Rules->errors()->first()
          ],422);
        }

        $expert = $request->user();
        //remmber ther is an important gitub to seefor profuo=ile update photo
         /* 
mdinzahaq22
/
Appointment-System-Laravel
Public



         */
       // $request->hasFile('profile-image');
       // #validate the profile 
       // $validate_image = Validator::make($request->all(), [
       //        'profile_image' => ['image|mimes:jpg,png,jpeg,gif,svg|max:2048']
       // ]);

       // if ($validate_image->fails()) {
       //     return response() -> json([
       //          'errors' => $validate_image->errors()->first()
       //     ]);
       //  }
        // $image_name = 'profile_image'.time().'.'.$request->
        //   profile_image->extension();
        // $request->profile_image->move(public_path('/uploads/profile_images'),$image_name);

           $expert->update([
                 'category_id' => $request->category_id,
                 'address' => $request->address,
                 'phone' => $request->phone,
                 'workspace_name' => $request->workspace_name,
                 'years_of_experience' => $request->years_of_experience,
                 'category' => $request->category,
                 'specialization' => $request->specialization,
                 'description' => $request->description,
                 // 'profile_image' => $profile_image
               ]);
                return response() -> json([
                    'message' => 'Profile Successfully updated',
               ],200);
         
    

}

public function Expert_Set_Times(Request $request) : JsonResponse
    {
        $inputs = $request->all();
     if(!empty($inputs)){
        $btimes = new BusinessTime;
        $btimes->expert_id = $inputs['expert_id'] ;
        $btimes->days = json_encode($inputs['days']);
        $btimes->mon_s = isset($inputs['mon_s']  ? $inputs['mon_s'] : '';
        $btimes->mon_e = isset($inputs['mon_e']) ? $inputs['mon_e'] : '';
        $btimes->tue_s = isset($inputs['tue_s']) ? $inputs['tue_s'] : '';
        $btimes->tue_e = isset($inputs['tue_e']) ? $inputs['tue_e'] : '';
        $btimes->wed_s = isset($inputs['wed_s']) ? $inputs['wed_s'] : '';
        $btimes->wed_e = isset($inputs['wed_e']) ? $inputs['wed_e'] : '';
        $btimes->thu_s = isset($inputs['thu_s']) ? $inputs['thu_s'] : '';
        $btimes->thu_e = isset($inputs['thu_e']) ? $inputs['thu_e'] : '';
        $btimes->fri_s = isset($inputs['fri_s']) ? $inputs['fri_s'] : '';
        $btimes->fri_e = isset($inputs['fri_e']) ? $inputs['fri_e'] : '';
        $btimes->sat_s = isset($inputs['sat_s']) ? $inputs['sat_s'] : '';
        $btimes->sat_e = isset($inputs['sat_e']) ? $inputs['sat_e'] : '';
        $btimes->sun_s = isset($inputs['sun_s']) ? $inputs['sun_s'] : '';
        $btimes->sun_e = isset($inputs['sun_e']) ? $inputs['sun_e'] : '';
        $btimes->step = $inputs['step'] ;

    if($btimes->save()){
            return response() -> json([
                    'message' => 'You set your times successfully',
               ],200);
        
       }
    }
}




  


    public function Expert_Login(Request $request) : JsonResponse
    {
        $request -> validate([
          'email' => ['required','email'],
          'password' =>['required','string'],

        ]);
        $credentials = request(['email', 'password']);
    #authinicate the expert
        if(auth::guard('expert')->attempt($request -> only(['email', 'password']))) {
            config(['auth.guards.api.provider' => 'expert']);
            $expert = Expert::query()->select('experts.*')->find(auth()->guard('expert')->user()->id);
            $success =  $expert;
            $success['token'] =  $expert->createToken('MyApp',['expert'])->accessToken; 
               return response()->json([$success, 200,'Success'=>'Logged in successfully']);
           }else{ 
               return response()->json(['error' => ['Unauthorized.']], 401);
        }
    }

    public function Expert_Logout(): JsonResponse
    {
        Auth::guard('expert-api')->user()->token()->revoke();
        return response()->json(['success'=>'Logged out successfully']);
    }

   
}
           

