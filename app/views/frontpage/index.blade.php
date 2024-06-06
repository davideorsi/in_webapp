@extends('layouts.frontmaster')

@section('content')

<!-- ======= Hero Section ======= -->
<section id="hero">
<div width="100%">
  <video autoplay="autoplay" muted="muted">
    <source  src={{'/images/front/IN-LogoAnimationHD.mp4'}} type="video/mp4">
  </video>
</div>
  <div class="hero-container" data-aos="fade-in" data-aos-delay="3000"data-aos-duration="2000" >
    <!--<h1 class="mb-4 pb-0"><img src="assets/img/IN_White_WEB_trasp.png" alt="Intempesta Noctis" class="img-fluid"></h1> -->
    <p class="mb-3 pb-0">Gioco di Ruolo dal Vivo Storico dalle atmosfere Gotiche, nel Ducato di Parma di inizio '800</p>
    <a href="https://youtu.be/FBaTL21aU14?si=W9bO3mPVW47uUZ4p" class="glightbox play-btn mb-4"></a>
    <a href="#about" class="about-btn scrollto">Scopri di più...</a>
  </div>
</section><!-- End Hero Section -->

<main id="main">

  <!-- ======= About Section ======= -->
  <section id="about">
    <div class="container" data-aos="fade-up">

    <p>Intempesta Noctis è un gioco di ruolo dal vivo che trasporta i giocatori nel Ducato di Parma nella prima metà del diciannovesimo secolo, dopo il Congresso di Vienna, quando l’Impero Francese e le idee rivoluzionarie avevano ormai lasciato spazio alla Restaurazione. Dopo la caduta di Napoleone, la nobiltà ha ripreso in mano le sorti dell’Europa, governandola legittimata dal diritto divino, in bilico tra una illuminata modernità e le antiche tradizioni e superstizioni.<p>
    <p>Il Marchese di La Rochelle e  il Conte di Nottingham amministrano, con i loro seguiti e famiglie, la città di Borgo San Donnino e territori annessi, in costante competizione tra antiche rivalità, interessi politici e giochi di potere. Questa convivenza forzata, in breve tempo eleva la rivalita al conflitto aperto: l'inusuale circostanza porta il Ducato di Parma Piacenza e Guastalla a diventare un grande centro di interesse politico attirando da tutta Europa diplomatici e delegazioni.</p>
    <p>Ma oscure presenze si muovono al Borgo: i morti si rialzano dai sepolcri, mostruosi ululati riecheggiano dai boschi, mentre tetri figuri si aggirano nell'ombra. Dicerie? Superstizioni? Poco è ciò che sembra e nessuno è al sicuro, nel Cuore della Notte.</p>

    </div>
  </section><!-- End About Section -->



 <!-- ======= Gallery Section ======= -->
  <section id="gallery">

    <div class="container" data-aos="fade-up">
      <div class="section-header">
        <h2>Eventi</h2>
        <p>Guarda i migliori scatti dai nostri eventi.</p>
      </div>
    </div>

    <div class="gallery-slider swiper">
      <div class="swiper-wrapper align-items-center">

    @foreach($Eventi as $Evento)

          <div class="swiper-slide" >
            <a href={{ URL::to('/gallery/'.$Evento['ID']) }} >
              <div class="slide-container">
                <img src={{'/images/gallery/'.$Evento['ID']. '.jpg'}} class="img-fluid" alt="">
                <div class="slide-text">
                  <h4>{{$Evento->Tipo}}: {{$Evento->Titolo}}</h4>
                  <p>{{$Evento->Data}}, {{$Evento->Luogo}}</p>
                </div>
              </div>
            </a>
          </div>

    @endforeach

        <div class="swiper-slide">
          <a href={{ URL::to('/gallery/0') }} class="gallery-lightbox">
            <div class="slide-container">
              <img src={{'/images/gallery/0.jpg'}} class="img-fluid" alt="">
               <div class="slide-text">
                <h4>Eventi Precedenti...</h4>
                <p></p>
              </div>
            </div>
          </a>
        </div>

      </div>
      <div class="swiper-pagination"></div>
    </div>

  </section><!-- End Gallery Section -->




 <!-- ======= Speakers Section ======= -->
  <section id="ambientazione" class="section-with-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-header">
        <h2>Ambientazione</h2>
        <p>Scopri il mondo di Intempesta Noctis</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="100">
            <img src={{'/images/ambientazione/ducato.jpg'}} alt="Ducato di Parma" class="img-fluid">
            <div class="details">
              <h3><a href="speaker-details.html">Il Ducato di Parma</a></h3>
       <div class="social">
        <p>Dove si svolgono le vicende di Intempesta Noctis</p>
       </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="200">
            <img src={{'/images/ambientazione/rochelle.jpg'}} alt="Famiglia La Rochelle" class="img-fluid">
            <div class="details">
              <h3><a href="speaker-details.html">Famiglia La Rochelle</a></h3>
               <div class="social">
        <p>Del Seguito del Marchese di La Rochelle e della Repubblica di Francia</p>
       </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="300">
            <img src={{'/images/ambientazione/nottingham.jpg'}} alt="Famiglia Nottingham" class="img-fluid">
            <div class="details">
              <h3><a href="speaker-details.html">Famiglia Nottingham</a></h3>
               <div class="social">
        <p>Del Seguito del Conte di Nottingham e del Regno di Gran Bretagna e Irlanda</p>
       </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="100">
            <img src={{'/images/ambientazione/mondo.jpg'}} alt="Il Mondo del 1830" class="img-fluid">
            <div class="details">
              <h3><a href="speaker-details.html">Il Mondo del 1830</a></h3>
              <div class="social">
        <p>Geografica, Cultura e Società dell'Europa della Restaurazione.</p>
       </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="200">
            <img src={{'/images/ambientazione/cronache.jpg'}} alt="Cronache del Passato" class="img-fluid">
            <div class="details">
              <h3><a href="/ambientazione/cronache">Cronache del Passato</a></h3>
               <div class="social">
        <p>L'almanacco degli avvenimenti di Borgo San Donnino, anno per anno.</p>
       </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="speaker" data-aos="fade-up" data-aos-delay="300">
            <img src={{'/images/ambientazione/notabili.jpg'}} alt="Notabili del Ducato" class="img-fluid">
            <div class="details">
              <h3><a href="/ambientazione/notabili">Notabili del Ducato</a></h3>
               <div class="social">
        <p>Scopri le vicende dei personaggi che hanno fatto la storia di Intempesta Noctis.</p>
       </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section><!-- End Speakers Section -->

  <section id="regolamento">
 <!-- ======= Regolamento Section ======= -->

    <div class="container" data-aos="fade-up">
      <div class="section-header">
        <h2>Regolamento</h2>
        <p>In questi manuali troverai tutte le regole che è necessario sapere per giocare a IN: è necessario conoscere il Tomo delle Regole, mentre il Tomo dell'Economia e il codice Penale sono opzionali.</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-3 col-md-6">
    <a href={{URL::to('files/tomo_delle_regole.pdf')}}>
          <div class="faction">
            <div class="faction-img">
              <img src={{'img/regole.jpg'}} alt="Tomo delle Regole" class="img-fluid">
      </div>
      <div class="faction-text">
       <h3>Tomo delle Regole</h3>
       <p></p>
      </div>
    </div>
           </a>
         </div>

        <div class="col-lg-3 col-md-6">
          <div class="faction">
      <a href={{URL::to('files/tomo_della_economia.pdf')}}>
            <div class="faction-img">
              <img src={{'img/economia.jpg'}} alt="Tomo della Economia" class="img-fluid">
            </div>
      <div class="faction-text">
        <h3>Tomo dell'Economia</h3>
        <p></p>
      </div>
      </a>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="faction">
      <a href={{URL::to('files/codice_penale_ducale_1827.pdf')}}>
      <div class="faction-img">
        <img src={{'img/codice_penale.png'}} alt="Codice Penale Ducale" class="img-fluid">
              </div>
        <div class="faction-text">
        <h3>Codice Penale</h3>
        <p></p>
      </div>
      </a>
          </div>
        </div>

    <div class="col-lg-3 col-md-6">
          <div class="faction">
      <a href={{URL::to('faq')}}>
      <div class="faction-img">
        <img src={{'img/faq.jpg'}} alt="Domande Frequnti ed Errata" class="img-fluid">
        </div>
        <div class="faction-text">
        <h3>Errata e Domande Frequenti</h3>
        <p>Aggiornamenti non ancora pubblicati e chiarimenti sul regolamento</p>
      </div>
      </a>
          </div>
        </div>


      </div>
    </div>


</section><!-- End Regolamento Section -->

<!-- ======= Buy Ticket Section ======= -->
<section id="partecipa" class="section-with-bg">

    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>Partecipa</h2>
        <p></p>
      </div>

      <div class="row">
        <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card mb-5 mb-lg-0">
            <div class="card-body">
              <h5 class="card-title text-muted text-uppercase text-center">PROSSIMO EVENTO:</h5>
              <h6 class="card-price text-center">{{$NextEvent['Titolo']}}</h6>
              <h4 class="card-title text-center ">{{$NextEvent['Tipo']}}</h4>
              <hr>

                 <span id="orari" >

                   <h4 class="card-title text-center ">
                   {{str_replace("\n", "<br>", $NextEvent['Orari'])}}
                   </h4>
                 </span>
              <hr>
              <div class="text-center">
                <h5 class="card-title text-muted text-uppercase text-center">LOCATION</h5>
               <span id="Luogo">{{$NextEvent['Luogo']}}</span>
               <br>
                <br>
      <iframe src="{{$NextEvent['Mappa']}}" frameborder="0" style="border:0" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
          <div class="card mb-5 mb-lg-0">
            <div class="card-body">
              <h6 class="card-price text-center">Come Iniziare</h6>
              <hr>
              <ul class="fa-ul">
                <li>
        <span class="fa-li"><i class="fa fa-check"></i></span>
        Fai Richiesta di Iscrizione. Scrivi a <a href="mailto:staff@intempestanoctis.it">staff@intempestanoctis.it</a> indicando come hai conosciuto Intempesta Noctis e perché ti piacerebbe farne parte. Ti verrà poi inviato un invito alla registrazione.
        </li>
                <li>
        <span class="fa-li"><i class="fa fa-check"></i></span>
        Iscriviti ai canali Social di IN <span class="social"> <a href="https://www.facebook.com/groups/257481273458"><i class="bi bi-facebook"></i></a>. Seguendo i nostri canali sarai sempre aggiornato sulle ultime Voci di Locanda, gli aggiornamenti sugli Eventi e vari Avvisi e Annunci sul gioco.

        </li>

                <li><span class="fa-li"><i class="fa fa-check"></i></span>Crea il tuo Personaggio! Scegli le abilità seguendo il <a href="#regolamento">regolamento</a></span>, scegli la Famglia di cui sarà membro e metti nero su bianco la sua storia (il "background"), più il background è dettagliato, meglio è! Una volta che il tuo personaggio è pronto, invia tutto a <a href="mailto:staff@intempestanoctis.it">staff@intempestanoctis.it</a>: dopo una rapida procedura di valutazione/approvazione, il personaggio  verrà inserito nel nostro database e collegato al tuo account.
</li>
                <li><span class="fa-li"><i class="fa fa-check"></i></span>Effettua il login. Approvato il personaggio, potrai accedere al sito con le tue credenziali ed utilizzare tutti gli strumenti che offre per arricchire il tuo gioco: Missive, Mercato, Artigianato Gestione del Personaggio e altro ancora.
</li>
                <li><span class="fa-li"><i class="fa fa-times"></i></span>Iscriviti a un Evento di Gioco. DEVI farlo sul sito effettuando il login, in questo modo godrai di una registrazione più veloce all’evento e potrai utilizzare alcune abilità che sono esclusive di questo passaggio. Ti consigliamo comunque di segnalare la tua partecipazione sui canali social.</li>

              </ul>
              <hr>
              <div class="text-center">
        <form action="https://www.intempestanoctis.it/">
          <button type="submit" class="btn" >Login</button>
        </form>
              </div>
            </div>
          </div>
        </div>
      </div>

</section><!-- End Partecipa Section -->

</main><!-- End #main -->
@stop
