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
        return view('project.index')->with(['labels' => Project::getLabels()]);
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
        $sponsor = Sponsor::where('project_id', $project->id)->first();

        $expirationDate = null;
        $alreadySponsored = false;

        $sponsor ? $expirationDate = $sponsor->created_at->addDays(30)->format('d/m/Y - H:i:s') : null;
        $sponsor ? $alreadySponsored = true : false;

        if ($project) {
            return view('project.show')->with(['project' => $project, 'sponsor' => $sponsor, 'alreadySponsored' => $alreadySponsored, 'expirationDate' => $expirationDate]);
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
                'description' => ['required', 'string'],
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

        if ($project) {
            $this->authorize('sponsor', $project);

            if ($request->isMethod('get')) {
                return view('project.edit')->with(['project' => $project, 'labels' => Project::getLabels()]);
            }
            if ($request->isMethod('post')) {
                Validator::make($request->all(), [
                    'name' => ['required', 'string', 'min:5', 'max:40', Rule::unique('projects')->ignore($project->id)],
                    'description' => ['required', 'string'],
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

        $expirationDate = null;

        $sponsor ? $expirationDate = $sponsor->created_at->addDays(30)->format('d/m/Y - H:i:s') : null;

        if ($project) {
            $this->authorize('sponsor', $project);

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
                    'description' => ['required', 'string'],
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

            } else {
                $projects = Project::all();
            }
            $totalProjects = $projects->count();
            if ($totalProjects > 0) {
                foreach ($projects as $project) {
                    $output .= '
        <tr>
         <td>' . $project->name . '</td>
         <td class="text-truncate" style="max-width: 300px;">' . $project->description . '</td>
         <td>' . $project->labels . '</td>
         <td>' . $project->leader->name . '</td>
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
}
