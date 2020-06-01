<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project;
use App\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('project.index')->with(['projects' => $projects]);
    }

    public function my()
    {
        $id = auth()->user()->id;
        $projectsAsLeader = Project::where('leader_id', $id)->get();

        return view('project.my')->with(['projectsAsLeader' => $projectsAsLeader]);
    }

    public function show(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            return view('project.show')->with(['project' => $project]);
        } else {
            return abort(404);
        }
    }

    public function create(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('project.create');
        }
        if ($request->isMethod('post')) {
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:5', 'max:40', 'unique:projects'],
                'description' => ['required', 'string'],
                'labels' => ['required', 'array'],
            ])->validate();

            $slug = Str::slug($request['name'], '-');
            $slugCode = Project::createProjectSlug();
            $uniqueSlug = $slug . "-" . $slugCode;

            Project::create([
                'name' => $request['name'],
                'description' => $request['description'],
                'labels' => implode(',', $request['labels']),
                'leader_id' => auth()->user()->id,
                'slug' => $uniqueSlug,
            ]);

            return redirect()->route('project.show', $uniqueSlug)
                ->with('message', __('message.project.created'));
        }
    }

    public function edit(Request $request)
    {
        $slug = $request['slug'];
        $project = Project::where('slug', $slug)->first();

        if ($project) {
            $this->authorize('sponsor', $project);

            if ($request->isMethod('get')) {
                return view('project.edit')->with(['project' => $project]);
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'name' => ['required', 'string', 'min:5', 'max:40', Rule::unique('projects')->ignore($project->id)],
                    'description' => ['required', 'string'],
                    'labels' => ['required', 'array'],
                ])->validate();

                $project->update([
                    'name' => $request['name'],
                    'description' => $request['description'],
                    'labels' => implode(',', $request['labels']),
                ]);

                return redirect()->route('project.show', $slug)
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
        $sponsor = Sponsor::where('project_id', $project->id)->first();

        if ($project) {
            $this->authorize('delete', $project);

            if ($sponsor) {
                $sponsor->delete();
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
        $sponsor = Sponsor::where('project_id', $project->id)->first();

        if ($project) {
            $this->authorize('sponsor', $project);

            if ($request->isMethod('get')) {
                if ($sponsor){
                    return redirect()->route('project.show', $slug)
                        ->with('message', __('message.project.alreadySponsored'));
                } else {
                    return view('project.sponsor')->with(['project' => $project]);
                }
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'title' => ['required', 'string', 'min:5', 'max:40'],
                    'description' => ['required', 'string'],
                ])->validate();

                Sponsor::create([
                    'project_id' => $project->id,
                    'title' => $request['title'],
                    'description' => $request['description'],
                ]);

                return redirect()->route('project.show', $slug)
                    ->with('message', __('message.project.sponsored'));
            }
        } else {
            return abort(404);
        }
    }
}
