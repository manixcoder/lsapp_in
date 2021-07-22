<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\UserRoleRelation;
use App\Models\Role;
use App\User;
use Newsletter;



class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/validate-user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
		 
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255','unique:users'],
            //'name'          => ['required|regex:/^[\pL\s\-]+$/u|max:255|unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password' => ['required', 'string', 'min:8'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            //'termsRadio' => ['required'],
            //'is_marketing_messages' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $newUserData = User::create([
            'name' 			=> $data['name'],
            'email' 		=> $data['email'],
            'password' 		=> Hash::make($data['password']),
            'first_name' 	=> $data['first_name'],
            'last_name' 	=> $data['last_name'],
            'lower_price'   => '1',
            'medium_price'  => '3',
            'higher_price'  =>'5',
            'single_price'  => '0',
            'is_marketing_messages' => $data['is_marketing_messages'],
        ]);
        // set Role for New Register Doctor 
        $roleArray = array(
                    'user_id' =>	$newUserData->id,
                    'role_id' =>	2,
                );

        Newsletter::subscribe($data['email']);
        //Newsletter::subscribe($data['email'], ['firstName'=>$data['first_name'], 'lastName'=>$data['last_name']]);
        

        //Newsletter::subscribePending($data['email']);
        UserRoleRelation::insert($roleArray);
        return $newUserData; 
    }
}
