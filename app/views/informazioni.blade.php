@extends('layouts.master')

@section('content')
<div class='col-sm-6 col-md-4 '>
	<h3>Benvenuto!</h3>
	<p class='justified'>Eccoti finalmente su Intempesta Noctis! Questo sito contiene tutto ciò che il giocatore deve sapere per poter giocare e per giocare: dai un'occhiata al menù in alto a sinistra. Troverai la sezione <strong>REGOLAMENTO</strong> con i manuali di gioco, la sezione <strong>AMBIENTAZIONE</strong> con tutto ciò che si può conoscere a priori dell’ambientazione, la sezione <strong>FORUM</strong> dove potersi consultare e dove eseguire comunicazioni ufficiali con lo staff. Se sei nuovo, al momento non potrai accedere completamente alle altre pagine: non ti preoccupare, ti spieghiamo subito da dove è meglio partire per entrare in questo mondo e iniziare a giocare.
	</p>

	<div class="separator">
		{{ HTML::image('img/divider.png') }}
	</div>

	<p class='justified'>
		Ogni giocatore di Intempesta Noctis è invitato a conoscere il “Tomo delle Regole”, scaricabile in pdf dalla sezione Regolamento. Non è da imparare TUTTO a memoria... Gli altri giocatori e i master ti verranno incontro se ti dimentichi qualcosa; l'importante è non prendere questo testo alla leggera, per non rischiare di rovinare il gioco degli altri partecipanti con comportamenti "fuori dalle regole". Invece, è facoltativo il “Tomo della Economia”. Per chi volesse cimentarsi nel gioco "economico", questo tomo è una guida a chi volesse sfruttarne le opportunità. Se il tuo personaggio si accontenta di sapere quanto costa una pinta di birra, puoi tranquillamente evitare di leggerlo.
	</p>

	<div class="separator visible-xs-block">
		{{ HTML::image('img/divider.png') }}
	</div>
</div>

<div  class='col-sm-6 col-md-4'>
	<h3>Come iniziare</h3>
	Sei nuovo e vuoi cominciare a giocare con noi? I passi da fare sono pochi e semplici.

	<p class='justified'>
	<ol class='justified'>
		<li><strong>Fai richiesta di iscrizione! </strong> Contatta uno dei master, se già li conosci, oppure invia una mail di presentazione a inazionifg@gmail.com indicando come hai conosciuto Intempesta Noctis e perchè ti piacerebbe farne parte. Ti verrà poi inviato un invito alla registrazione.</li>
		<li><strong>Crea il tuo personaggio!</strong> Armati di carta e penna, scegli le abilità seguendo il regolamento e metti nero su bianco la sua storia (il "background"), scegliendo anche la Fazione di cui eventualmente sarà membro. Più il background è dettagliato, meglio è! Una volta che il tuo personaggio è pronto, comunica tutti i suoi dati a uno dei Master tramite messaggio privato sul Forum: il personaggio, dopo una rapida procedura di valutazione/approvazione, verrà inserito nel nostro database e collegato al tuo account</li>
		<li><strong>Iscriviti ad un evento di gioco! </strong> Potrai farlo direttamente su questo sito. Ti invitiamo anche ad iscriverti, su Facebook, <a style='color:#41A317' href='https://www.facebook.com/groups/257481273458/'>al gruppo “Intempesta Noctis”</a>. Sul gruppo vengono pubblicati annunci, avvisi, date degli eventi e quant’altro possa essere utile, in particolare verrai avvisato quando viene pubblicata una nuova "Voce di Locanda".</li>

	</ol>
	</p>

	<div class="separator">
		{{ HTML::image('img/divider.png') }}
	</div>

</div>

<div  class='col-sm-6 col-md-4'>
	<h3>Nel Frattempo...</h3>
	<p class='justified'>
		Tra un evento di Gioco e l'altro, il mondo di Intempesta Noctis non si ferma!
		Su questo sito, trovi la <strong>scheda personaggio</strong>, contenente i dati fondamentali del tuo personaggio, punti esperienza (PX), PX liberi, rendita del personaggio (PG), eventuali note. Essa serve ad avere sempre la situazione sotto controllo. Lo staff aggiornerà i PX disponibili ad ogni evento e tu potrai decidere di spenderli acquistando nuove abilità, mediante l'apposito selettore. Ricorda che, per poter scegliere determinate abilità avanzate, occorre aver prima acquistato le abilità di base necessarie a sbloccarle.
		Ogni PG può riuscire a sbloccare <strong>abilità speciali</strong> che non sono descritte nel regolamento. Per fare questo è necessario che il PG abbia alcuni prerequisiti e che si soddisfino delle condizioni di trama adatte. Nella scheda personaggio puoi vedere se il tuo PG ha abilità speciali sbloccate. In una apposita sezione, troverai un resoconto delle abilità speciali che hai acquistato, dato che esse non sono presenti nel regolamento consultabile sul sito.
	</p>

	<div class="separator">
		{{ HTML::image('img/divider.png') }}
	</div>

	<h3>Corrispondenza</h3>
	<p class='justified'>
	Se hai necessità di comunicare con PG o PNG tra un live e l'altro, puoi inviare una lettera! Ogni PG ha la sezione "Missive" abilitata, e tutti i pg possono ricevere missive. Ricorda che se il tuo non ha l'abilità "Leggere e Scrivere" non potrà scrivere missive, ma protrà leggerle (si presume che abbia qualcuno che gliele legge).<br> La sezione di corrispondenza è considerata IN GIOCO ed è quindi obbligatorio scrivere lettere come se fosse il personaggio (e non il giocatore) a farlo. Scrivere missive può avere un costo (vedi il “Tomo delle Regole” a pag. 13, capitolo “Corrispondenza”) che verrà addebitato ad inizio evento successivo. Ogni missiva viene datata con la data dell’ultima voce di locanda pubblicata, in tutti i casi mai oltre essa (se è il 10 Ottobre la lettera avrà la data dell’ultima voce di locanda che comunque non sarà postuma al 10 Ottobre).

	Tieni a mente le seguenti regole:
	<ul>
	<li> nelle missive a PNG non è possibile firmarsi col nome di altri o di personaggi inesistenti a meno che non vi sia una spiegazione plausibile (fanno eccezione le possibilità sbloccate dall’abilità “Doppia Identità”). E’ possibile, invece, non firmarsi;</li>
	<li>non è possibile mandare missive tra PG anonime. Il destinatario vedrà sempre il mittente;</li>
	<li>è possibile inviare missive firmate a più mani solo se tutti i mittenti ne sono a conoscenza e sono d’accordo. Inoltre tutti i mittenti secondari riceveranno una copia delle missiva;</li>
	<li>non è possibile inserire nelle missive descrizioni di azioni del PG. Una lettera è solamente il testo scritto di proprio pugno e inviato tal quale. Ogni altra azione deve essere descritta con i master e generalmente compiuta in gioco lungo un evento. </li>
	</ul>
	
	</p>
		
	
</div>



@stop

@section('Scripts')



	
	
@stop
