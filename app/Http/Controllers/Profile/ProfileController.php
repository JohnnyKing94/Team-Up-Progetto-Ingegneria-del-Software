<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $id = auth()->user()->id;
        Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255',  Rule::unique('users')->ignore($id)],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:50'],
            'birthday' => ['required', 'date'],
            'skills' => ['required', 'string'],
            'interests' => ['required', 'array']
        ])->validate();;

        User::where('id', $id)->update([
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'name' => $request['name'],
            'surname' => $request['surname'],
            'gender' => $request['gender'],
            'birthday' => $request['birthday'],
            'skills' =>  $request['skills'],
            'interests' => implode(',',$request['interests']),
        ]);
        return redirect()->back()
            ->with('success', __('customMessage.profileUpdated'));
    }
}
