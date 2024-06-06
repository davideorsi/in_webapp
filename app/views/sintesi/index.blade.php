@extends('admin')

  @section('CSS')
  <style>
    .circleB {
      height: 30px;
      width: 30px;
      background-color: #000;
      border-radius: 50%;
      border: 1px solid black;
    }
    .circleW {
      height: 30px;
      width: 30px;
      background-color: #FFF;
      border-radius:50%;
      border: 1px solid black;
    }
    .circleR {
      height: 30px;
      width: 30px;
      background-color: #F00;
      border-radius:50%;
      border: 1px solid black;
    }
    #cromo_Rosso{
        background-color: #ff0000;
    }
    #cromo_Verde{
        background-color: #00ff00;
    }
    #cromo_Blu{
        background-color: #0000ff;
    }
    #cromo_Magenta{
        background-color: #ff00ff;
    }
    #cromo_Giallo{
        background-color: #ffff00;
    }
    #cromo_Ciano{
        background-color: #00ffff;
    }
    #cromo_Viola{
        background-color: #8000ff;
    }
    #cromo_Azzurro{
        background-color: #0080ff;
    }
    #cromo_Primavera{
        background-color: #00ff80;
    }
    #cromo_Prato{
        background-color: #80ff00;
    }
    #cromo_Arancione{
        background-color: #ff8000;
    }
    #cromo_Bianco{
        background-color: #ffffff;
    }
    #cromo_Rosa{
        background-color: #ff0080;
    }
    #cromo_Nero{
        background-color: #000000;
    }

  </style>
	@stop
  @section('content')

    <h3>Sintesi</h3>
    @if ( Session::has('message'))
    <div class="alert alert-info">
      {{ Session::get('message') }}
    </div>
    @endif

    <div class="row" style='margin-left:00px;'>
      <div class='col-12'>
        <span style="font-size: 20px;">Cartellini Oggetto ({{$CartelliniRimanenti}}/{{$CartelliniRimanenti+$CartelliniUsati}}): </span>
        <div>
        @for($r = 0;$r<$CartelliniRimanenti;$r++)
        <span class='glyphicon glyphicon-unchecked' style="font-size: 20px;"></span>
        @endFor
        @for($u = 0;$u<$CartelliniUsati;$u++)
        <span class='glyphicon glyphicon-check' style="font-size: 20px;"></span>
        @endFor
        </div>

      </div>
    </div>
    <br>
    <div class="row" style='margin-left:00px;'>
      <div class='col-6'>
        <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="pills-sintesi-tab" data-toggle="pill" href="#pills-sintesi" role="tab" aria-controls="pills-sintesi" aria-selected="true">Sintesi</a>
          </li>
          @if($ricercatore)
          <li class="nav-item">
            <a class="nav-link" id="pills-analisi-tab" data-toggle="pill" href="#pills-analisi" role="tab" aria-controls="pills-analisi" aria-selected="false">Analisi</a>
          </li>
          @endif
          @if($maestro)
          <li class="nav-item">
            <a class="nav-link" id="pills-estratti-tab" data-toggle="pill" href="#pills-estratti" role="tab" aria-controls="pills-estratti" aria-selected="false">Estratti</a>
          </li>
          @endif
          @if(Auth::user()->usergroup == 7)
          <li class="nav-item">
            <a class="nav-link" id="pills-storico-tab" data-toggle="pill" href="#pills-storico" role="tab" aria-controls="pills-storico" aria-selected="false">Storico</a>
          </li>
          @endif
        </ul>
      </div>
    </div>
    <br>
    <div class="row"  style='margin-left:00px;'>
        <div class='col'>
          <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade" id="pills-sintesi" role="tabpanel" aria-labelledby="pills-sintesi-tab">
            <div class="row no-gutters" >
              <div class='col-sm-6'>

                <h3>Sintesi Sostanze</h3>
                <br>
                <h4>Matrice</h4>
        				{{ Form::open(array('class'=>'form form-horizontal','method'=>'PUT','url' => 'sintesi/sintetizza')) }}
                <div class="form-inline">
        					<div class="input-group col-sm-3">
        						<span class="input-group-addon danger" id="sizing-addon1">
        							<span class='glyphicon glyphicon-leaf '></span>
        						</span>
        						{{Form::input('number', 'rosse', 0,['id'=>'rosse', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon1", 'min'=>'0'])}}
        					</div>
        					<div class="input-group col-sm-3">
        						<span class="input-group-addon success" id="sizing-addon2">
        							<span class='glyphicon glyphicon-leaf'></span>
        						</span>
        						{{Form::input('number', 'verdi', 0,['id'=>'verdi', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon2", 'min'=>'0'])}}
        					</div>
        					<div class="input-group col-sm-3">
        						<span class="input-group-addon primary" id="sizing-addon3">
        							<span class='glyphicon glyphicon-leaf'></span>
        						</span>
        						{{Form::input('number', 'blu'  , 0,['id'=>'blu', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon3", 'min'=>'0'])}}
        					</div>
                </div>

                <br>

                @if ($alchimia)

                <h4>Materiali
                <a class="btn btn-warning" href="#" onclick="add_mat_sintesi('tab-mat-sintesi')">
                  <span class="glyphicon glyphicon-plus"></span> Aggiungi Materiale
                </a>
                </h4>
                <table class="table table-striped col-sm-9" id="tab-mat-sintesi">

                 </table>
                  @endif

                <br>
                <h4>Laboratorio</h4>
                	<div class="input-group col-sm-9">
                {{ Form::select('selectLab', $selectLab, 0, ['class'=>'form-control', 'id'=>'selectLab']) }}
                </div>
                <br>
                @if ($CartelliniRimanenti>0)
                {{ Form::submit("Sintetizza", array('class' => 'btn btn-info')) }}
                @else
                {{ Form::submit("Sintetizza", array('class' => 'btn btn-info disabled')) }}
                @endif
                {{ Form::close() }}
          	   </div>

      	      <div class='col-sm-6'>
             <h3>Storico Sintesi</h3>
        		 @foreach($SintesiPG as $esperimento)

               @if($esperimento['diluizione']!=0)
                   <div class="row bs-callout bs-callout-warning">
               @else
                 @if($esperimento['id_sostanza'])
             		   <div class="row bs-callout bs-callout-success">
                 @else
                   <div class="row bs-callout bs-callout-danger">
                 @endif
               @endif
                  <!--matrice-->
                  <label for="Matrice">Matrice</label>
                   <div class="form-inline">
                     <div class="input-group col-sm-3">
                       <span class="input-group-addon danger" id="sizing-addon1">
                         <span class='glyphicon glyphicon-leaf '></span>
                       </span>
                       {{Form::input('number', 'r_'.$esperimento['id_sintesi'], $esperimento['R_matrice'],['id'=>'r_'.$esperimento['id_sintesi'], 'class'=>'form-control', 'disabled'])}}
                     </div>
                     <div class="input-group col-sm-3">
                       <span class="input-group-addon success" id="sizing-addon2">
                         <span class='glyphicon glyphicon-leaf'></span>
                       </span>
                       {{Form::input('number', 'v_'.$esperimento['id_sintesi'], $esperimento['V_matrice'],['id'=>'v_'.$esperimento['id_sintesi'], 'class'=>'form-control', 'disabled'])}}
                     </div>
                     <div class="input-group col-sm-3">
                       <span class="input-group-addon primary" id="sizing-addon3">
                         <span class='glyphicon glyphicon-leaf'></span>
                       </span>
                       {{Form::input('number', 'b_'.$esperimento['id_sintesi']  , $esperimento['B_matrice'],['id'=>'b_'.$esperimento['id_sintesi'], 'class'=>'form-control', 'disabled'])}}
                     </div>
                   </div>
                   <br>

                @if (count($esperimento->mat()->Get())>0)
             <!--elenco materiali-->
                  <label for="Materiali">Materiali</label>
                  <table>
                    @foreach($esperimento->mat()->Get() as $materiale)
                      <tr>
                        <td >{{$materiale['Nome']}} </td >
                        <td > {{$materiale['quantita']}}</td >
                      </tr>
                    @endforeach
                  </table>
                  <br>
                @endif
             <!--cromodinamica-->

             <label>Cromodinamica</label>
              {{Form::input('text', 'cromo_'.$esperimento->Cromodinamica['DESC'],$esperimento->Cromodinamica['DESC'] ,['id'=>'cromo_'.$esperimento->Cromodinamica['DESC'],  'disabled']) }}


              @if($esperimento['diluizione']!=0)
                  @if($esperimento['diluizione'] < 0)
                       <!--Bianco troppo diluito-->
                    <div class="circleW"></div>
                  @else
                      <!--Nero troppo concentrato-->
                    <div class="circleB"></div>
                  @endif
                  @if($esperimento['rubedo'] == 1)
                    <div class="circleR"></div>
                  @endif

              @else
                @if($esperimento['id_sostanza'])

                  <br>

                  <!--Effetti-->
                  <label>Effetti</label>
                  {{ Form::text('effetti_'.$esperimento['id_sintesi'],$esperimento->Sostanza['effetti'], ['class'=>'form-control', 'disabled']) }}

                @else
                  @if($esperimento['rubedo'] == 1)
                    <div class="circleR"></div>
                  @endif

                @endif
              @endif

            </div>
        		 @endforeach

      	    </div>
            </div>
           </div>
          <div class="tab-pane fade" id="pills-analisi" role="tabpanel" aria-labelledby="pills-analisi-tab">
            <div class="row no-gutters" >
              <div class='col-sm-6'>
                <h3>Analisi Materiali</h3>
                <br>
                {{ Form::open(array('class'=>'form form-horizontal','method'=>'PUT','url' => 'sintesi/analizza')) }}

                  <table class="table table-striped col-sm-9" id="tab-mat-sintesi">
                    <thead class="thead-inverse">
                      <tr>
                        <th style="width: 60%">Materiale</th>
                      </tr>
                    </thead>
                    <tr>
                      <td >{{ Form::text('materiale_analisi', null, ['class'=>'form-control','placeholder'=>'scrivi esattamente come sul cartellino']) }}</td>
                    </tr>
                   </table>

                   <br>
                   <h4>Laboratorio</h4>
                   	<div class="input-group col-sm-9">
                   {{ Form::select('selectLabAnalisi', $selectLab, 0, ['class'=>'form-control', 'id'=>'selectLabAnalisi']) }}
                   </div>
                   <br>
                @if ($CartelliniRimanenti>0)
                {{ Form::submit("Analizza", array('class' => 'btn btn-info')) }}
                @else
                {{ Form::submit("Analizza", array('class' => 'btn btn-info disabled')) }}
                @endif
                {{ Form::close() }}
              </div>
              <div class='col-sm-6'>
               <h3>Storico Analisi</h3>
                @foreach($AnalisiPG as $analisi)
                  <div class="row bs-callout bs-callout-primary">
                    <label for="Materiali">Materiale</label>
                    <table>
                        <tr>
                          <td >{{$analisi->materiale['Nome']}} </td >
                        </tr>
                    </table>
                    <br>
                    <label>Cromodinamica</label>
                     {{Form::input('text', 'cromo_'.$analisi->Cromodinamica['DESC'],$analisi->Cromodinamica['DESC'] ,['id'=>'cromo_'.$analisi->Cromodinamica['DESC'],  'disabled']) }}

                  </div>
                @endforeach

               </div>
             </div>
          </div>
          <div class="tab-pane fade" id="pills-estratti" role="tabpanel" aria-labelledby="pills-estratti-tab">
            <div class="row no-gutters" >
              <div class='col-sm-6'>
                <h3>Crea Estratti</h3>
                <br>

                {{ Form::open(array('class'=>'form form-horizontal','method'=>'PUT','url' => 'sintesi/estrai')) }}

                  <table class="table table-striped col-sm-9" id="tab-mat-sintesi">
                    <thead class="thead-inverse">
                      <tr>
                        <th style="width: 60%">Materiale</th>
                        <!--<th style="width: 25%">Q.ta</th>-->
                      </tr>
                    </thead>
                    <tr>
                      <td >{{ Form::text('materiale_estratti', null, ['class'=>'form-control']) }}</td>
                      <!--<td >{{ Form::input('number', 'qta_estratti[]', 1, ['class'=>'form-control']) }}</td>-->
                      </tr>
                   </table>


                   <br>
                   <h4>Laboratorio</h4>
                   <div class="input-group col-sm-9">
                   {{ Form::select('selectLabEstratti', $selectLab, 0, ['class'=>'form-control', 'id'=>'selectLabEstratti']) }}
                   </div>
                  <br>
                @if ($CartelliniRimanenti>0)
                {{ Form::submit("Estrai", array('class' => 'btn btn-info')) }}
                @else
                  <!--{{ Form::submit("Estrai", array('class' => 'btn btn-info disabled')) }}-->
                @endif
                {{ Form::close() }}
              </div>
              <div class='col-sm-6'>
               <h3>Storico Estratti</h3>
                @foreach($EstrattiPG as $estratto)
                  @if($estratto->id_estratto!=null)
                    <div class="row bs-callout bs-callout-success">
                  @else
                    <div class="row bs-callout bs-callout-danger">
                  @endif
                    <label for="Materiali">Materiale</label>
                    <table>
                        <tr>
                          <td >{{$estratto->Materiale['Nome']}} </td >
                        </tr>
                    </table>
                    <br>
                    <label>Estratto</label>
                    <table>
                        <tr>
                          <td >{{$estratto->Estratto['Nome']}} </td >
                        </tr>
                    </table>
                  </div>
                @endforeach

               </div>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-storico" role="tabpanel" aria-labelledby="pills-storico-tab">
              <div class="row no-gutters" >
                  <div class='col-sm-6'>
                    <h3>Ricerca</h3>
                    <br>

                      {{Form::open(array('onsubmit'=>'get_list_sintesi(1); return false;')) }}
                      <!--{{ Form::open(array('files'=>true,'class'=>'form form-horizontal','method'=>'GET','url' => 'admin/sintesi/search'))}}-->
                      <div class="form-group col-sm-9" >
                        <div class="input-group margin-bottom">
                        <span class="input-group-addon" id="basic-addon-PG">Personaggio</span>
                        {{ Form::select('pgSearch', $selPG, Input::old('pgSearch'), ['class'=>'form-control','describedby'=>"basic-addon-CD"]) }}
                        </div>
                      </div>

                      <div class="form-group col-sm-9" >
                        <div class="input-group margin-bottom">
                          <span class="input-group-addon" id="basic-addon-Da">Da</span>
                          {{ Form::input('date','dataInizio', Input::old('dataInizio'), ['class'=>'form-control','describedby'=>"basic-addon-datainizio"]) }}
                        </div>
                        <div class="input-group margin-bottom">
                          <span class="input-group-addon" id="basic-addon-A">A</span>
                          {{ Form::input('date','dataFine', Input::old('dataFine'), ['class'=>'form-control','describedby'=>"basic-addon-datafine"]) }}
                        </div>
                      </div>

                      <div class="form-group col-sm-9" >
                				<div class="input-group margin-bottom">
                				<span class="input-group-addon" id="basic-addon-evento">Evento</span>
                				{{ Form::select('eventoSearch', $selEvento, Input::old('eventoSearch'), ['class'=>'form-control','describedby'=>"basic-addon-CD"]) }}
                				</div>
                			</div>

                      <div class="form-group col-sm-9" >
                        <div class="input-group margin-bottom">
                        <span class="input-group-addon" id="basic-addon-sostanza">Sostanza</span>
                        {{ Form::text('sostanzaSearch', Input::old('sostanzaSearch'), ['class'=>'form-control','describedby'=>"basic-addon-materiali"]) }}
                        </div>
                      </div>

                      <div class="form-group col-sm-9" >
                        <div class="input-group margin-bottom">
                        <span class="input-group-addon" id="basic-addon-sostanza">Effetti</span>
                        {{ Form::text('effettiSearch', Input::old('effettiSearch'), ['class'=>'form-control','describedby'=>"basic-addon-effetti"]) }}
                        </div>
                      </div>

                      <div class="form-group col-sm-9" >
                				<div class="input-group margin-bottom">
                				<span class="input-group-addon" id="basic-addon-CD">Cromodinamica</span>
                				{{ Form::select('CDsearch', $selCD, Input::old('CDsearch'), ['class'=>'form-control','describedby'=>"basic-addon-CD"]) }}
                				</div>
                			</div>

                      <div class="form-group col-sm-9" >
                        <div class="input-group margin-bottom">
                        <span class="input-group-addon" id="basic-addon-diluizione">Diluizione</span>
                          {{ Form::input('number','diluizioneSearch', Input::old('diluizioneSearch'), ['class'=>'form-control','describedby'=>"basic-addon-diluizione"]) }}
                        </div>
                      </div>

                      <div class="form-group col-sm-9" >
                        <div class="input-group margin-bottom">
                        <span class="input-group-addon" id="basic-addon-materiali">Materiali</span>
                        {{ Form::text('materialiSearch', Input::old('materialiSearch'), ['class'=>'form-control','describedby'=>"basic-addon-materiali",'placeholder'=>'Parole chiave, es: Boletus Satanas']) }}
                        </div>
                      </div>

                      <div class="form-group col-sm-9" >
                				<div class="input-group">

                					<span class="input-group-addon danger" id="sizing-addon1">
                						<span class='glyphicon glyphicon-leaf '></span>
                					</span>
                					{{Form::input('number', 'Rsearch', Input::old('Rsearch'),['id'=>'Rsearch', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon1"])}}
                					<span class="input-group-addon success" id="sizing-addon2">
                						<span class='glyphicon glyphicon-leaf'></span>
                					</span>
                					{{Form::input('number', 'Vsearch', Input::old('Vsearch'),['id'=>'Vsearch', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon2"])}}
                					<span class="input-group-addon primary" id="sizing-addon3">
                						<span class='glyphicon glyphicon-leaf'></span>
                					</span>
                					{{Form::input('number', 'Bsearch'  , Input::old('Bsearch'),['id'=>'Bsearch', 'class'=>'form-control', 'aria-describedby'=>"sizing-addon3"])}}
                				</div>
                			</div>
                      <div class="form-group col-sm-9" >
                        <div class="input-group">
                      {{ Form::submit("Cerca", array('class' => 'btn btn-info')) }}
                        </div>
                      </div>
                      {{ Form::close() }}
                  </div>

                  <div class='col-sm-6' >
                		<div id='parent-list'>
                			<div id='pagine' class='col-sm-8'></div>
                			<div class='col-sm-10'>
                				<ul class='media-list' id='results'></ul>
                				<div class="panel-group" id="accordion"></div>
                			</div>
                		</div>

                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>


	@stop

  @section('Scripts')
    $(function(ready) {
      $('#pills-tab a[href="#{{$tab }}"]').tab('show')
    });
  @stop
