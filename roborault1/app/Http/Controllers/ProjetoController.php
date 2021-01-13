<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Categoria;
use App\Models\Foto;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projetos = Projeto::all(); // = select * from projetos
        return view('projetos.index', compact('projetos'));
        // The compact mehod passes the results from the select to the index view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorias = Categoria::all(); // = SELECT * FROM categorias;
        return view('projetos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Project Form validation
        request()->validate([
            'inputDesignation' => 'required',
            'selectCategory' => 'required',
            'inputResponsibles' => 'required',
            'inputInitialDate' => 'required',
            'inputGitHub' => 'required',
            'inputDescription' => 'required'
        ]);

        // Data insertion in Project Form
        $project = new Projeto();
        $project->sDesignation = request('inputDesignation');
        $project->categoria_id=request('selectCategory');
        $project->sResponsible=request('inputResponsibles');
        $project->dInitialDate=request('inputInitialDate');
        $project->sGitHub=request('inputGitHub');
        $project->sDescription=request('inputDescription');

        $request->validate([
            'imageFile' => 'required',
            'imageFile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
          ]);

        if($request->hasfile('imageFile')) {

            $project->save(); // It only saves the project if images exist

            foreach($request->file('imageFile') as $file)
            {
                $name = $file->getClientOriginalName();
                $file->move(public_path().'/uploads/', $name);
                $imgData[] = $name;
            }

            $fileModal = new Foto();
            $fileModal->sDesignation = json_encode($imgData);
            $fileModal->projeto_id = $project->id;

            $fileModal->save();
        }
        return redirect('/projetos')->with('message', 'Projeto inserido com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function show(Projeto $projeto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function edit(Projeto $projeto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Projeto $projeto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projeto $projeto)
    {
        //
    }
}
