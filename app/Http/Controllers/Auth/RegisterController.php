<?php

namespace App\Http\Controllers\Auth;

use App\CountryZone;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
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
    protected $redirectTo = '/home';

    /**
     * @var CountryZone|null
     */
    protected $countryZone = null;

    /**
     * Create a new controller instance.
     * Create an instance of CountryZone model
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->countryZone = new CountryZone();
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string'],
            'country' => ['required'],
            'state' => ['required'],
            'city' => ['required', 'string'],
            'address' => ['required'],
            'post_code' => ['required', 'string'],
            'logo' => ['required', 'string'],
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'country' => $data['country'],
            'state' => $data['state'],
            'city' => $data['city'],
            'address' => $data['address'],
            'post_code' => $data['post_code'],
            'logo' => $data['logo'],
        ]);
    }

    /**
     * Get a list of zones and display the data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getZones()
    {
        $zonesList['zones'] = $this->countryZone->zones();

        return view('auth.zones', $zonesList);
    }
}
