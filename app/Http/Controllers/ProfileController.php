<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileController
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['profile'] = Auth::user();

        return view('profile.index', $data);
    }

    public function edit(EditProfileRequest $request, int $id)
    {
        $user = Auth::user();
        $editUser = User::find($id);

        $validated = $request->all();

        if($request->file('logo') && $request->file('logo')->isValid()) {
            if($user->logo != null) {
                if(file_exists(public_path('/uploads/'.$user->logo))) {
                    unlink(public_path('/uploads/'.$user->logo));
                }
            }

            $path = './uploads/';

            $filename = time().'.'.$validated['logo']->getClientOriginalName();

            $request->file('logo')->move($path, $filename);

            $editUser->logo = $filename;
        }

        $editUser->name = $validated['name'];
        $editUser->phone = $validated['phone'];
        $editUser->city = $validated['city'];
        $editUser->address = $validated['address'];
        $editUser->post_code = $validated['post_code'];

        $editUser->save();

        return redirect()->back()->with('message', 'You have successfully updated your profile!');
    }

    public function update(Request $request, int $id)
    {
        $user = Auth::user();
        $editUser = User::findOrFail($id);

        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $editUser->password = Hash::make($request->password);

        $editUser->save();

        return redirect()->back()->with('message', 'You password has been updated!');
    }
}
