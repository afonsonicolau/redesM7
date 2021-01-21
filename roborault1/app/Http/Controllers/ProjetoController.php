<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Categoria;
use App\Models\Foto;
use Illuminate\Http\Request;
use PhpParser\JsonDecoder;

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

        $project->save();

        $request->validate([
            'imageFile' => 'required',
            'imageFile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:4096'
          ]);


        $fileModal = new Foto();

        if($request->hasfile('imageFile')) {

            $i = 1;

            foreach($request->file('imageFile') as $file)
            {
                $name = $file->getClientOriginalName();
                $extension = pathinfo($name, PATHINFO_EXTENSION); // Image extension
                $sDesignation = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$project->sDesignation);
                $sDesignation = str_replace(' ', '',$sDesignation);
                $name = $sDesignation . $i . ".". $extension;
                $file->storeAs('public/uploads/', $name);
                $imgData[] = $name;
                $i++;
            }


        }else{
            $imgData = [];


        }

        $fileModal->sDesignation = json_encode($imgData);
        $fileModal->projeto_id = $project->id;

        $fileModal->save();

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
        // Detalhes de um projeto

        $foto = Foto::where('projeto_id', $projeto->id) -> first();
        $fotos = json_decode($foto->sDesignation);

        return view('projetos.show', compact('projeto', 'fotos'));
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
        $categorias = Categoria::all(); // = SELECT * FROM categorias;
        $foto = Foto::where('projeto_id', $projeto->id) -> first(); // SELECT * FROM foto WHERE fotos.projeto_id = projetos.projeto_id
        if($foto) {
            // If images associated to the project exist
            $jDesignations = json_decode($foto->sDesignation);
        }
        else
        {
            $jDesignations = [];
        }

        return view('projetos.edit', compact('categorias', 'projeto', 'foto', 'jDesignations'));
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

        $project->save();

        $request->validate([
            'imageFile.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:4096'
          ]);

        if($request->hasfile('imageFile')) {
            $fileModal = Foto::where('projeto_id', $projeto->id)->first();

            $fotos = ($fileModal) ? json_decode($fileModal->sDesignation) : [];

            $i = 1;

            if (count($fotos) > 0) {
                // Descobre o número presente na designação e soma uma unidade.
                $i = (int) filter_var($fotos[count($fotos)-1], FILTER_SANITIZE_NUMBER_INT) + 1;
            }

            foreach($request->file('imageFile') as $file)
            {
                $name = $file->getClientOriginalName();
                $extension = pathinfo($name, PATHINFO_EXTENSION); // Image extension
                $sDesignation = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$project->sDesignation);
                $sDesignation = str_replace(' ', '',$sDesignation);
                $name = $sDesignation . $i . ".". $extension;
                $file->storeAs('public/uploads/', $name);
                $imgData[] = $name;
                $i++;
            }

            $imgData = array_merge($fotos, $imgData);
            $fileModal->sDesignation = json_encode($imgData);

            $fileModal->save();
        }

        return redirect('/projetos')->with('message', 'Projeto alterado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Projeto  $projeto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Projeto $projeto)
    {
        // Eliminar um projeto

        $projeto->delete();

        return redirect('/projetos')->with('message', 'Projeto eliminado com sucesso.');
    }
}
