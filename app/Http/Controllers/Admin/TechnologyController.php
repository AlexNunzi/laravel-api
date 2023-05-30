<?php

namespace App\Http\Controllers\Admin;

use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use Illuminate\Support\Str;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $technologies = Technology::all();

        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.technologies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        $form_data = $request->validated();

        $newTechnology = new Technology();

        $newTechnology->fill($form_data);
        $newTechnology->slug = str::slug($newTechnology->name, '-');

        $checkType = Technology::where('slug', $newTechnology->slug)->first();
        if ($checkType) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug per questa tecnologia, è necessario modificare il nome']);
        }

        $newTechnology->save();

        return redirect()->route('admin.technologies.show', ['technology' => $newTechnology->slug])->with('status', 'Tecnologia creata con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        return view('admin.technologies.show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.edit', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        $form_data = $request->validated();
        $form_data['slug'] = str::slug($form_data['name'], '-');

        $checkProject = Technology::where('slug', $form_data['slug'])->where('id', '<>', $technology->id)->first();

        if ($checkProject) {
            return back()->withInput()->withErrors(['slug' => 'Impossibile creare lo slug per questa tecnologia, è necessario modificare il nome']);
        }

        $technology->update($form_data);

        return redirect()->route('admin.technologies.show', ['technology' => $technology->slug])->with('status', 'Tecnologia aggiornata con successo!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('admin.technologies.index');
    }
}
