@extends('layouts.frontmaster')

@section('content')

<main id="main" class="main-page">

  <section id="notabili">
  <!-- ======= Regolamento Section ======= -->

    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>Notabili del Ducato</h2>
        <p>Scopri le vicende dei personaggi che hanno fatto la storia di Intempesta Noctis.</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
      @foreach($Notabili as $notabile)
        <div class="col-lg-3 col-md-6">
          <a href={{URL::to('/ambientazione/notabili/'.$notabile['ID'])}}>
            <div class="faction">
              <div class="faction-img">
                <img src={{'/images/famoso/'.$notabile['ID']}} alt={{$notabile['Nome']}} class="img-fluid">
              </div>
              <div class="faction-text">
               <h3>{{$notabile['Nome']}}</h3>
               <p>{{$notabile['Epitaffio']}}</p>
              </div>
            </div>
          </a>
        </div>
      @endforeach


  </section><!-- End Regolamento Section -->


</main><!-- End #main -->

@stop
