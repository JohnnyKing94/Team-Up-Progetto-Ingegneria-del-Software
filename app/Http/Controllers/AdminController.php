<?php

namespace App\Http\Controllers;

use App\Message;
use App\ParticipationRequest;
use App\Project;
use App\Sponsor;
use App\Teammate;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('isAdmin');

        $users = User::all();
        foreach ($users as $user) {
            $user->interests = User::spacingInterests($user->interests);
        }
        return view('admin.user.index')->with(['users' => $users]);
    }

    public function edit(Request $request)
    {
        $this->authorize('isAdmin');
        $slug = $request['slug'];
        $user = User::where('slug', $slug)->first();

        if ($user) {
            $user->interests = User::arrayInterests($user->interests);

            if ($request->isMethod('get')) {
                return view('admin.user.edit')->with(['user' => $user, 'interests' => User::getInterests()]);
            }
            if ($request->isMethod('post')) {
                if (!$request->has('password')) {
                    $request->except(['password']);
                }

                Validator::make($request->all(), [
                    'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                    'password' => ['nullable', 'min:8', 'confirmed'],
                    'name' => ['required', 'string', 'max:255'],
                    'surname' => ['required', 'string', 'max:255'],
                    'gender' => ['required', 'string', 'max:50'],
                    'birthday' => ['required', 'date', 'older_than:18'],
                    'skills' => ['required', 'string'],
                    'interests' => ['required', 'array']
                ])->validate();

                $data = $request->all();

                if (empty($data['password'])) {
                    User::where('id', $user->id)->update([
                        'email' => $request['email'],
                        'name' => $request['name'],
                        'surname' => $request['surname'],
                        'gender' => $request['gender'],
                        'birthday' => $request['birthday'],
                        'skills' => $request['skills'],
                        'interests' => implode(',', $request['interests']),
                    ]);
                } else {
                    User::where('id', $user->id)->update([
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
        } else {
            abort(404);
        }
    }

    public function delete(Request $request)
    {
        $this->authorize('isAdmin');
        $slug = $request['slug'];
        $user = User::where('slug', $slug)->first();

        if ($user) {
            $projectsAsLeader = Project::where('leader_id', $user->id);
            $projectsAsTeammate = Teammate::where('teammate_id', $user->id);
            if ($projectsAsLeader->exists()) {
                foreach ($projectsAsLeader->get() as $projectAsLeader) {
                    $sponsor = Sponsor::where('project_id', $projectAsLeader->id);
                    $teammates = Teammate::where('project_id', $projectAsLeader->id);
                    $participationRequests = ParticipationRequest::where('project_id', $projectAsLeader->id);
                    $messages = Message::where('project_id', $projectAsLeader->id);

                    if ($sponsor->exists()) {
                        $sponsor->delete();
                    } else if ($teammates->exists()) {
                        $teammates->delete();
                    } else if ($participationRequests->exists()) {
                        $participationRequests->delete();
                    } else if ($messages->exists()) {
                        $messages->delete();
                    }
                    $projectAsLeader->delete();
                }
            }
            if ($projectsAsTeammate->exists()) {
                $projectsAsTeammate->delete();
            }

            $user->delete();

            return redirect()->route('admin.user.index')
                ->with('message', __('message.admin.userDeleted'));
        } else {
            abort(404);
        }
    }
}