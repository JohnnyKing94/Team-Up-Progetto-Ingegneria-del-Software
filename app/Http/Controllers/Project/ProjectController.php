<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\ParticipationRequest;
use App\Project;
use App\Sponsor;
use App\Team;
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
        $id = auth()->user()->id;
        $projects = User::where('id', $id)->with('asLeader')->with('asTeammate')->first();
        foreach ($projects->asLeader as $projectAsLeader) {
            $projectAsLeader->labels = Project::spacingLabels($projectAsLeader->labels);
        }

        return view('project.my')->with(['projects' => $projects]);
    }

    public function show(Request $request)
    {
        $id = auth()->user()->id;
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $isPending = ParticipationRequest::where('teammate_id', $id)->where('project_id', $project->id)->first();
            $isTeammate = Team::where('teammate_id', $id)->where('project_id', $project->id)->first();
            $isLeader = Project::where('leader_id', $id)->where('id', $project->id)->first();

            $project = Project::where('id', $project->id)->with('userTeam')->first();
            $project->labels = Project::spacingLabels($project->labels);
            $sponsor = Sponsor::where('project_id', $project->id)->first();

            $expirationDate = null;
            $alreadySponsored = false;

            $sponsor ? $expirationDate = $sponsor->created_at->addDays(30)->format('d/m/Y - H:i:s') : null;
            $sponsor ? $alreadySponsored = true : false;

            return view('project.show')->with(['project' => $project, 'sponsor' => $sponsor,
                'alreadySponsored' => $alreadySponsored, 'expirationDate' => $expirationDate,
                'isPending' => $isPending, 'isTeammate' => $isTeammate, 'isLeader' => $isLeader]);
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

            Project::create([
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
            $this->authorize('sponsor', $project);

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

            $sponsor = Sponsor::where('project_id', $project->id)->first();
            $teams = Team::where('project_id', $project->id)->first();
            $participationRequests = ParticipationRequest::where('project_id', $project->id)->first();

            if ($sponsor) {
                $sponsor->delete();
            } else if ($teams){
                $teams->delete();
            } else if ($participationRequests){
                $participationRequests->delete();
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
            $sponsor ? $expirationDate = $sponsor->created_at->addDays(30)->format('d/m/Y - H:i:s') : null;

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
         <td>' . $project->leader->name . ' ' . \Illuminate\Support\Str::limit($project->leader->surname, 1, $end = '.') . '</td>
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
        $id = auth()->user()->id;
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            // $this->authorize('join', $project);
            $isPending = ParticipationRequest::where('teammate_id', $id)->where('project_id', $project->id)->first();
            $isTeammate = Team::where('teammate_id', $id)->where('project_id', $project->id)->first();
            $isLeader = Project::where('leader_id', $id)->where('id', $project->id)->first();

            if ($request->isMethod('get')) {
                if ($isPending) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.already.requested'));
                } else if ($isTeammate) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.already.member'));
                } else if ($isLeader) {
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.already.leader'));
                } else {
                    return view('project.join')->with(['project' => $project]);
                }
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'reason' => ['required', 'string', 'min:10'],
                ])->validate();

                ParticipationRequest::create([
                    'teammate_id' => auth()->user()->id,
                    'project_id' => $project->id,
                    'reason' => $request['reason'],
                    'identifier' => ParticipationRequest::createIdentifier(),
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
        $id = auth()->user()->id;
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            // $this->authorize('cancelJoin', $project);
            $isPending = ParticipationRequest::where('teammate_id', $id)->where('project_id', $project->id)->first();
            $isTeammate = Team::where('teammate_id', $id)->where('project_id', $project->id)->first();
            $isLeader = Project::where('leader_id', $id)->where('id', $project->id)->first();


            if ($request->isMethod('get')) {
                if ($isPending) {
                    $isPending->delete();
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.join.canceled'));
                } else if ($isTeammate || $isLeader) {
                    return abort(404);
                } else {
                    return view('project.show')->with(['project' => $project]);
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
                        Team::create([
                            'teammate_id' => $participationRequest->teammate_id,
                            'project_id' => $participationRequest->project_id,
                            'identifier' => Team::createIdentifier(),
                            'join_date' => Carbon::now(),
                        ]);

                        return redirect()->route('project.manageRequests', $slug)
                            ->with('message', __('message.project.join.request.accepted'));
                    }
                    if ($request->has('decline')) {
                        $participationRequest->delete();

                        return redirect()->route('project.manageRequests', $slug)
                            ->with('message', __('message.project.join.request.declined'));
                    }
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }
}
