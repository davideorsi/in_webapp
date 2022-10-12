@extends('admin')

	@section('content')
	<div>

		<h3>Parametri dell'algoritmo</h3>


		@if ( Session::has('message'))
			<div class="alert alert-info">
				{{ Session::get('message') }}
			</div>
		@endif
	</div>
		<div class="row bs-callout bs-callout-Default">
      <div class="col-md-6 col-md-offset-3">
				{{ Form::model($parametri, array('files'=>true, 'method' => 'PUT', 'url' => 'admin/malattie/parametri/edit/'.$parametri['ID'])) }}
				<div class="form-group">
				<div class="form-group">
        <div class="input-group">
          {{ Form::label('ProbBase', 'Probabilita Base') }}
          {{ Form::input('number','ProbBase',$parametri['ProbBase'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('ProbMAX', 'Probabilita Massima') }}
          {{ Form::input('number','ProbMAX',$parametri['ProbMAX'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('MaxMalati', 'Massimale PG malati') }}
          {{ Form::input('number','MaxMalati',$parametri['MaxMalati'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaExtra', 'Soglia Cicatrici perse per ignorare il Massimale') }}
          {{ Form::input('number','SogliaExtra',$parametri['SogliaExtra'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('ProbCibo', '% da Mancato Consumo di Cibo') }}
          {{ Form::input('number','ProbCibo',$parametri['ProbCibo'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('ProbCicaLow', '% da Cicatrici Perse Fascia Bassa') }}
          {{ Form::input('number','ProbCicaLow',$parametri['ProbCicaLow'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('ProbCicaMid', '% da Cicatrici Perse Fascia Media') }}
          {{ Form::input('number','ProbCicaMid',$parametri['ProbCicaMid'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('ProbCicaTop', '% da Cicatrici Perse Fascia Alta') }}
          {{ Form::input('number','ProbCicaTop',$parametri['ProbCicaTop'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaCicaLow', 'Soglia Cicatrici Bassa') }}
          {{ Form::input('number','SogliaCicaLow',$parametri['SogliaCicaLow'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaCicaTop', 'Soglia Cicatrici Alta') }}
          {{ Form::input('number','SogliaCicaTop',$parametri['SogliaCicaTop'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaGravCiboL', 'Soglia Gravita Bassa: Cibo') }}
          {{ Form::input('number','SogliaGravCiboL',$parametri['SogliaGravCiboL'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaGravCiboT', 'Soglia Gravita Alta: Cibo') }}
          {{ Form::input('number','SogliaGravCiboT',$parametri['SogliaGravCiboT'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaGravFerL', 'Soglia Gravita Bassa: Ferite') }}
          {{ Form::input('number','SogliaGravFerL',$parametri['SogliaGravFerL'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaGravFerT', 'Soglia Gravita Alta: Ferite') }}
          {{ Form::input('number','SogliaGravFerT',$parametri['SogliaGravFerT'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaGravMisL', 'Soglia Gravita Bassa: Misto') }}
          {{ Form::input('number','SogliaGravMisL',$parametri['SogliaGravMisL'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaGravMisT', 'Soglia Gravita Alta: Misto') }}
          {{ Form::input('number','SogliaGravMisT',$parametri['SogliaGravMisT'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('SogliaMalusF', 'Soglia Cicatrici Perse per applicare il Malus') }}
          {{ Form::input('number','SogliaGravMisT',$parametri['SogliaGravMisT'],['class'=>'form-control']) }}
        </div>
				<br>
        <div class="input-group">
          {{ Form::label('MalusF', 'Malus alla Gravitá per troppe ferite perse') }}
          {{ Form::input('number','MalusF',$parametri['MalusF'],['class'=>'form-control']) }}
        </div>
				<br>
        {{ Form::submit('Salva Modifiche ', array('class' => 'btn btn-primary')) }}
        {{ Form::close() }}
			</div>
			</div>
		</div>




@show



@stop

@section('Scripts')
@stop
