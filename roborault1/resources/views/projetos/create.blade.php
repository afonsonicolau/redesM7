@extends('layouts.admin')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Projetos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Novo Projeto</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Novo Projeto</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="/projetos" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="inputDesignation">Designação</label>
                                <input type="text" class="form-control" name="inputDesignation" id="inputDesignation"
                                    placeholder="Insira a desginação do projeto">
                            </div>
                            <div class="form-group">
                                <label for="selectCategory">Categoria</label>
                                <select class="form-control select2" name="selectCategory" id="selectCategory"
                                    style="width: 100%;">
                                    <option value="default" selected="selected">Selecione uma categoria</option>

                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->sDesignation }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputResponsibles">Aluno(s) Responsável(eis)</label>
                                <input type="text" class="form-control" id="inputResponsibles" name="inputResponsibles"
                                    placeholder="Insira o(s) aluno(s) responsável(eis)">
                            </div>
                            <div class="form-group">
                                <label for="inputInitialDate">Data de Início</label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="inputInitialDate"
                                        name="inputInitialDate">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputGitHub">GitHub</label>
                                <input type="text" class="form-control" id="inputGitHub" name="inputGitHub"
                                    placeholder="Insira o repositório de GitHub utilizado">
                            </div>
                            <div class="form-group">
                                <label for="inputDescription">Descrição</label>
                                <textarea class="form-control" rows="5" id="inputDescription" name="inputDescription"
                                    placeholder="Insira a descrição do projeto"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="inputImages">Fotos/Imagens</label>
                                <div class="user-image mb-3 text-center">
                                    <div class="imgPreview"> </div>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="images" name="imageFile[]" multiple="multiple">
                                        <label class="custom-file-label" for="images">Escolha um
                                            ficheiro...</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Submeter Imagens</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success" id="btnSubmit" name="btnSubmit">Submeter</button>
                            <button type="reset" class="btn btn-warning" id="btnReset" name="btnReset">Limpar</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection
