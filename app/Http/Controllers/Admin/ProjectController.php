<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        $types = Type::all();

        return view('admin.projects.index', compact('projects', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $form_data = $request->validated();

        if ($request->hasFile('preview_img')) {
            $path = Storage::put('previews', $request->preview_img);
            $form_data['preview_img'] = $path;
        }

        $newProject = new Project();

        $newProject->fill($form_data);
        $newProject->slug = str::slug($newProject->title, '-');

        $checkProject = Project::where('slug', $newProject->slug)->first();
        if ($checkProject) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug per questo progetto, è necessario modificare il titolo']);
        }

        $newProject->save();

        if ($request->has('technologies')) {
            $newProject->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.projects.show', ['project' => $newProject->slug])->with('status', 'Progetto creato con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $form_data = $request->validated();
        $form_data['slug'] = str::slug($form_data['title'], '-');

        $checkProject = Project::where('slug', $form_data['slug'])->where('id', '<>', $project->id)->first();

        if ($checkProject) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug per questo progetto, è necessario modificare il titolo']);
        }

        if ($request->hasFile('preview_img')) {

            if ($project->preview_img) {
                Storage::delete($project->preview_img);
            }

            $path = Storage::put('previews', $request->preview_img);
            $form_data['preview_img'] = $path;
        }

        $project->technologies()->sync($request->technologies);

        $project->update($form_data);

        return redirect()->route('admin.projects.show', ['project' => $project->slug])->with('status', 'Progetto aggiornato con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index');
    }

    public function deletePreview(Project $project)
    {
        if ($project->preview_img) {
            Storage::delete($project->preview_img);
            $project->preview_img = null;
            $project->save();
        }

        return redirect()->route('admin.projects.edit', $project->slug);
    }
}
