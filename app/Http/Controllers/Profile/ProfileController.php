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

    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('profile.edit');
        }
        if ($request->isMethod('post')) {
            $id = auth()->user()->id;

            if (!$request->has('password')) {
                $request->except(['password']);
            }

            Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
                'password' => ['nullable', 'min:8', 'confirmed'],
                'name' => ['required', 'string', 'max:255'],
                'surname' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'max:50'],
                'birthday' => ['required', 'date'],
                'skills' => ['required', 'string'],
                'interests' => ['required', 'array']
            ])->validate();

            $data = $request->all();

            if (empty($data['password'])) {
                User::where('id', $id)->update([
                    'email' => $request['email'],
                    'name' => $request['name'],
                    'surname' => $request['surname'],
                    'gender' => $request['gender'],
                    'birthday' => $request['birthday'],
                    'skills' => $request['skills'],
                    'interests' => implode(',', $request['interests']),
                ]);
            } else {
                User::where('id', $id)->update([
                    'email' => $request['email'],
                    'password' => Hash::make($request['password']),
                    'name' => $request['name'],
                    'surname' => $request['surname'],
                    'gender' => $request['gender'],
                    'birthday' => $request['birthday'],
                    'skills' => $request['skills'],
                    'interests' => implode(',', $request['interests']),
                ]);
            }

            return redirect()->back()
                ->with('message', __('message.profile.updated'));
        }
    }
}
