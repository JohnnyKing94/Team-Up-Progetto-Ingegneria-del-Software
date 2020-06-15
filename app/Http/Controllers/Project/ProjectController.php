<?php

namespace App\Http\Controllers\Project;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Message;
use App\ParticipationRequest;
use App\Project;
use App\Sponsor;
use App\Teammate;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        return view('project.index')->with(['labels' => Project::getLabels()]);
    }

    public function my()
    {
        $userID = auth()->user()->id;
        $projects = User::where('id', $userID)->with('asLeader')->with('asTeammate')->first();
        if ($projects) {
            foreach ($projects->asLeader as $projectAsLeader) {
                $projectAsLeader->labels = Project::spacingLabels($projectAsLeader->labels);
            }
            foreach ($projects->asTeammate as $projectAsTeammate) {
                $projectAsTeammate->labels = Project::spacingLabels($projectAsTeammate->labels);
            }
        }

        return view('project.my')->with(['projects' => $projects]);
    }

    public function show(Request $request)
    {
        $userID = auth()->user()->id;
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $project = Project::where('id', $project->id)->with('userTeam')->first();
            $project->labels = Project::spacingLabels($project->labels);
            $sponsor = Sponsor::where('project_id', $project->id)->first();

            $expirationDate = null;
            $alreadySponsored = false;

            $sponsor ? $expirationDate = $sponsor->date : null;
            $sponsor ? $alreadySponsored = true : false;

            return view('project.show')->with(['project' => $project, 'sponsor' => $sponsor,
                'alreadySponsored' => $alreadySponsored, 'expirationDate' => $expirationDate,
                'isPending' => User::isPending($userID, $project), 'isTeammate' => User::isTeammate($userID, $project), 'isLeader' => User::isLeader($userID, $project), 'isAdmin' => User::isAdmin($userID),]);
        } else {
            return abort(404);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('project.create')->with(['labels' => Project::getLabels()]);
        }
        if ($request->isMethod('post')) {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:5', 'max:40', 'unique:projects'],
                'description' => ['required', 'string', 'min:10'],
                'labels' => ['required', 'array'],
            ])->validate();

            $slugName = Str::slug($request['name'], '-');
            $slugCode = Project::createSlugCode();
            $slug = $slugName . "-" . $slugCode;

            (new Project)->create([
                'name' => $request['name'],
                'description' => $request['description'],
                'labels' => implode(',', $request['labels']),
                'leader_id' => auth()->user()->id,
                'slug' => $slug,
            ]);

            return redirect()->route('project.show', $slug)
                ->with('message', __('message.project.created'));
        }
    }

    public function edit(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();
        $project->labels = Project::arrayLabels($project->labels);

        if ($project) {
            $this->authorize('edit', $project);

            if ($request->isMethod('get')) {
                return view('project.edit')->with(['project' => $project, 'labels' => Project::getLabels()]);
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'name' => ['required', 'string', 'min:5', 'max:40', Rule::unique('projects')->ignore($project->id)],
                    'description' => ['required', 'string', 'min:10'],
                    'labels' => ['required', 'array'],
                ])->validate();

                $slug = $project->slug;
                $slugName = Str::slug($project->name, '-');

                $newSlugName = Str::slug($request['name'], '-');
                $slugCode = str_replace($slugName . '-', '', $slug);
                $newSlug = $newSlugName . "-" . $slugCode;

                $project->update([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'labels' => implode(',', $request['labels']),
                    'slug' => $newSlug,
                ]);

                return redirect()->route('project.show', $newSlug)
                    ->with('message', __('message.project.updated'));
            }
        } else {
            return abort(404);
        }
    }

    public function delete(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $this->authorize('delete', $project);

            $sponsor = Sponsor::where('project_id', $project->id);
            $teammates = Teammate::where('project_id', $project->id);
            $participationRequests = ParticipationRequest::where('project_id', $project->id);
            $messages = Message::where('project_id', $project->id);

            if ($sponsor->exists()) {
                $sponsor->delete();
            } else if ($teammates->exists()) {
                $teammates->delete();
            } else if ($participationRequests->exists()) {
                $participationRequests->delete();
            } else if ($messages->exists()) {
                $messages->delete();
            }
            $project->delete();

            return redirect()->home()
                ->with('message', __('message.project.deleted'));
        } else {
            return abort(404);
        }
    }

    public function sponsor(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $this->authorize('sponsor', $project);

            $sponsor = Sponsor::where('project_id', $project->id)->first();
            $expirationDate = null;
            $sponsor ? $expirationDate = $sponsor->date : null;

            if ($request->isMethod('get')) {
                if ($sponsor) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.sponsor.already', ['date' => $expirationDate]));
                } else {
                    return view('project.sponsor')->with(['project' => $project]);
                }
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'title' => ['required', 'string', 'min:5', 'max:40'],
                    'description' => ['required', 'string', 'min:10'],
                ])->validate();

                Sponsor::create([
                    'project_id' => $project->id,
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'date' => Carbon::now(),
                ]);

                return redirect()->route('project.show', $slug)
                    ->with('message', __('message.project.sponsor.created'));
            }
        } else {
            return abort(404);
        }
    }

    public function searchProject(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $byName = $request->get('byName');
            $byLabel = $request->get('byLabel');

            if ($byName != '' || $byLabel != '') {
                $projects = Project::where('name', 'like', '%' . $byName . '%')
                    ->where(function ($query) use ($byLabel) {
                        if (!empty($byLabel)) {
                            foreach ($byLabel as $key => $value) {
                                $query->where('labels', 'like', '%' . $value . '%');
                            }
                        }
                    })->get();
                foreach ($projects as $project) {
                    $project->labels = Project::spacingLabels($project->labels);
                }

            } else {
                $projects = Project::all();
                foreach ($projects as $project) {
                    $project->labels = Project::spacingLabels($project->labels);
                }
            }
            $totalProjects = $projects->count();
            if ($totalProjects > 0) {
                foreach ($projects as $project) {
                    $output .= '
        <tr>
         <td>' . $project->name . '</td>
         <td class="text-truncate" style="max-width: 300px;">' . $project->description . '</td>
         <td>' . $project->labels . '</td>
         <td>' . $project->leader->name . ' ' . Str::limit($project->leader->surname, 1, $end = '.') . '</td>
         <td><a href="' . route('project.show', $project->slug) . '"><i class="far fa-eye"></i></a></td>
        </tr>
        ';
                }
            } else {
                $output = '
       <tr>
        <td align="center" colspan="5">' . __('field.project.search.noData') . '</td>
       </tr>
       ';
            }
            $data = array(
                'table_data' => $output,
                'total_data' => $totalProjects
            );

            echo json_encode($data);
        }
    }

    public function sendJoin(Request $request)
    {
        $userID = auth()->user()->id;
        $user = User::find($userID);
        $user->interests = User::spacingInterests($user->interests);
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $project->labels = Project::spacingLabels($project->labels);
            // $this->authorize('join', $project);

            if ($request->isMethod('get')) {
                if (User::isPending($userID, $project)) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.already.requested'));
                } else if (User::isTeammate($userID, $project)) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.already.member'));
                } else if (User::isLeader($userID, $project)) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.already.leader'));
                } else {
                    return view('project.join')->with(['project' => $project, 'user' => $user]);
                }
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'reason' => ['required', 'string', 'min:10'],
                ])->validate();

                (new ParticipationRequest)->create([
                    'teammate_id' => auth()->user()->id,
                    'project_id' => $project->id,
                    'reason' => $request['reason'],
                    'identifier' => ParticipationRequest::createIdentifier(),
                    'date' => Carbon::now(),
                ]);

                return redirect()->route('project.show', $slug)
                    ->with('message', __('message.project.join.done'));
            }
        } else {
            return abort(404);
        }
    }

    public function cancelJoin(Request $request)
    {
        $userID = auth()->user()->id;
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            // $this->authorize('cancelJoin', $project);

            if ($request->isMethod('get')) {
                if (User::isPending($userID, $project)) {
                    ParticipationRequest::where('teammate_id', $userID)->where('project_id', $project->id)->delete();
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.canceled'));
                } else if (User::isTeammate($userID, $project) || User::isLeader($userID, $project)) {
                    return abort(404);
                } else {
                    return redirect()->route('project.show', $slug);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function manageRequests(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $this->authorize('manageRequests', $project);

            $project = Project::where('id', $project->id)->with('userRequests')->first();
            foreach ($project->userRequests as $userRequest) {
                $userRequest->interests = Project::spacingLabels($userRequest->interests);
            }

            if ($request->isMethod('get')) {
                return view('project.requests')->with(['project' => $project]);
            }
            if ($request->isMethod('post')) {
                $accept = $request['accept'];
                $decline = $request['decline'];

                if ($accept) {
                    $identifier = $request['accept'];
                } elseif ($decline) {
                    $identifier = $request['decline'];
                } else {
                    return abort(404);
                }

                $participationRequest = ParticipationRequest::where('identifier', $identifier)->first();
                if ($participationRequest) {
                    if ($request->has('accept')) {
                        $participationRequest->delete();
                        (new Teammate)->create([
                            'teammate_id' => $participationRequest->teammate_id,
                            'project_id' => $participationRequest->project_id,
                            'identifier' => Teammate::createIdentifier(),
                            'date' => Carbon::now(),
                        ]);

                        return redirect()->route('project.manageRequests', $slug)
                            ->with('message', __('message.project.join.request.accepted'));
                    }
                    if ($request->has('decline')) {
                        $participationRequest->delete();

                        return redirect()->route('project.manageRequests', $slug)
                            ->with('message', __('message.project.join.request.declined'));
                    }
                } else {
                    return abort(404);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function leave(Request $request)
    {
        $userID = auth()->user()->id;
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            // $this->authorize('leave', $project);

            if ($request->isMethod('get')) {
                if (User::isPending($userID, $project)) {
                    return abort(404);
                } else if (User::isTeammate($userID, $project)) {
                    Teammate::where('teammate_id', $userID)->where('project_id', $project->id)->delete();
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.leave.asTeammate'));
                } else if (User::isLeader($userID, $project)) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.leave.asLeader'));
                } else {
                    return redirect()->route('project.show', $slug);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function removeTeammate(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project->exists()) {
            $this->authorize('removeTeammate', $project);

            if ($request->isMethod('get')) {
                abort(403);
            }
            if ($request->isMethod('post')) {
                $identifier = $request['removeTeammate'];
                $teammate = Teammate::where('identifier', $identifier);
                if ($teammate->exists()) {
                    $teammate->delete();

                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.removedTeammate'));
                } else {
                    return abort(403);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function chat(Request $request)
    {
        $userID = auth()->user()->id;
        $user = User::find($userID);
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->with('userMessages')->first();

        if ($project) {
            $project = Project::where('id', $project->id)->with('userTeam')->first();
            $project->labels = Project::spacingLabels($project->labels);

            if ($request->isMethod('get')) {
                if (User::isTeammate($userID, $project) || User::isLeader($userID, $project) || User::isAdmin($userID)) {
                    return view('project.chat')->with(['project' => $project, 'user' => $user]);
                } else if (User::isPending($userID, $project)) {
                    return abort(401);
                } else {
                    return abort(401);
                }
            }
        } else {
            return abort(404);
        }
    }

    public function message(Request $request)
    {
        $userID = auth()->user()->id;
        $user = User::find($userID);
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->with('userMessages')->first();

        if ($project) {
            if ($request->isMethod('get')) {
                if (User::isTeammate($userID, $project) || User::isLeader($userID, $project) || User::isAdmin($userID)) {
                    return Message::with('user')->where('project_id', $project->id)->get();
                } else if (User::isPending($userID, $project)) {
                    return abort(401);
                } else {
                    return abort(401);
                }
            }
            if ($request->isMethod('post')) {
                if (User::isTeammate($userID, $project) || User::isLeader($userID, $project) || User::isAdmin($userID)) {
                    /*                Validator::make($request->all(), [
                                        'message' => ['required', 'min:3'],
                                    ])->validate();*/

                    $message = Message::create([
                        'user_id' => $user->id,
                        'project_id' => $project->id,
                        'message' => $request['message'],
                        'date' => Carbon::now(),
                    ]);

                    broadcast(new NewMessage($message->load('user')))->toOthers();

                    return ['status' => 'success'];
                } else if (User::isPending($userID, $project)) {
                    return abort(401);
                } else {
                    return abort(401);
                }
            }
        } else {
            return abort(404);
        }
    }
}
