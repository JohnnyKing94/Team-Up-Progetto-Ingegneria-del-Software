<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $projectsAsLeader = Project::where('ownerid', $id)->get();

        return view('project.my')->with(['projectsAsLeader' => $projectsAsLeader]);
    }

    public function show(Request $request)
    {
        $slug = $request['slug'];
        $detailProject = Project::where('slug', $slug)->first();

        return view('project.show')->with(['detailProject' => $detailProject]);
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
                'ownerid' => auth()->user()->id,
                'slug' => $uniqueSlug,
            ]);

            return redirect()->home()
                ->with('message', __('customMessage.projectCreated'));
        }
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            $slug = $request['slug'];
            $detailProject = Project::where('slug', $slug)->first();

            return view('project.edit')->with(['detailProject' => $detailProject]);
        }
        if ($request->isMethod('post')) {
            $slug = $request['slug'];
            $nameCurrent = DB::table('projects')->select('name')->where('slug', $slug)->get();
            Validator::make($request->all(), [
                'name' => ['required', 'string', 'min:5', 'max:40', Rule::unique('projects')->ignore($nameCurrent)],
                'description' => ['required', 'string'],
                'labels' => ['required', 'array'],
            ])->validate();

            Project::where('slug', $slug)->update([
                'name' => $request['name'],
                'description' => $request['description'],
                'labels' => implode(',', $request['labels']),
            ]);

            return redirect()->back()
                ->with('message', __('customMessage.projectUpdated'));
        }
    }
    public function delete(Request $request)
    {
        $slug = $request['slug'];

        Project::where('slug', $slug)->delete();

        return redirect()->home()
            ->with('message', __('customMessage.projectDeleted'));
    }

}
