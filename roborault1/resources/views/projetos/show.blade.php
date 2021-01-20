@extends('layouts.outer')

@section('content')

<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs" style="background-color: #e8e8e8">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2></h2>
          <ol>
            <li><a href="/">Início</a></li>
            <li>Detalhes de Projeto</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row">

          <div class="col-lg-8">
            <h2 class="portfolio-title">{{ $projeto->sDesignation }}</h2>
            <div class="owl-carousel portfolio-details-carousel">
                @foreach ($fotos as $foto)
                    <img style="max-height: 500px" src="{{ asset('storage/uploads')."/".$foto }}" class="img-fluid" alt="">
                @endforeach

            </div>
          </div>

          <div class="col-lg-4 portfolio-info">
            <h3><u>Informações do Projeto</u></h3>
            <ul>
              <li><strong>Categoria</strong>: {{ $projeto->Categoria->sDesignation }}</li>
              <li><strong>Responsáveis</strong>: {{ $projeto->sReponsible }}</li>
              <li><strong>Data de Início</strong>: {{ $projeto->dInitialDate }}</li>
              <li><strong>GitHub</strong>: <a href="{{ $projeto->sGitHub }}">{{ $projeto->sGitHub }}</a></li>
            </ul>

            <p>
                {{ $projeto->sDescription }}
            </p>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->
@endsection
