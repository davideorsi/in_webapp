@extends('layouts.frontmaster')

@section('content')

<main id="main" class="main-page">
      <br>
  <!-- ======= Speaker Details Sectionn ======= -->
      <section id="speakers-details">
        <div class="container">
          <div class="section-header">
            <h2>{{$Notabile['Nome']}}</h2>
            <p>{{$Notabile['Epitaffio']}}</p>
          </div>

          <div class="row">
            <div class="col-md-3">
              <img src={{"/images/famoso/".$Notabile['ID']}} alt={{$Notabile['Nome']}} class="img-fluid">
            </div>

            <div class="col-md-9">
              <div class="details">
                <p>
                {{$Notabile['Storia'][0]}}
        				<br>
        				{{$Notabile['Storia'][1]}}
                </p>
              </div>
            </div>

          </div>
        </div>

      </section>

</main><!-- End #main -->

@stop
