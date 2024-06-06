@extends('layouts.frontmaster')

@section('content')

<main id="main" class="main-page">
	<section id="venue">

      <div class="container-fluid" data-aos="fade-up">
        <a href="/front#gallery" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-left-short"></i></a>
        @if($Evento!=null)
        <div class="section-header">
          <h2>{{$Evento['Tipo']}}: {{$Evento['Titolo']}}</h2>
          <p>{{$Evento['Data']}}, {{$Evento['Luogo']}}</p>
        </div>
        @endIf
        <div class="container-fluid venue-gallery-container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-0">
          @foreach($Pics as $Pic)
          <div class="col-lg-3 col-md-4">
            <div class="venue-gallery">
              <a href={{'/images/gallery/'.$Evento['ID'].'/'.$Pic}} class="glightbox" data-gall="venue-gallery">
                <img src={{'/images/gallery/'.$Evento['ID'].'/'.$Pic}} alt="" class="img-fluid">
              </a>
            </div>
          </div>
          @endforeach

        </div>
      </div>
	</div>
	</section>

  </main><!-- End #main -->

@stop
