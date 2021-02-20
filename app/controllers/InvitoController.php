<?php

class InvitoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$Inviti = Invito::orderBy('ID', 'desc')->where('Usato','=',0)->get(array('ID','Email','Key'));
		
		return View::make('invito.index')
			->with('Inviti', $Inviti->toarray());
	}




	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$rules = array(
			'Email' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/invito')
				->withErrors($validator);
		} else {
			
			$Email	=Input::get('Email');
			$Key = bin2hex(openssl_random_pseudo_bytes(16));
			
			// store
			$invito = new Invito;
			$invito->Email=$Email;
			$invito->Key=$Key;
			$invito->save();
			
			$oggetto="Invito ad Intempesta Noctis";
			$salt="hash_intempesta_noctis";
			$chiave=hash('sha256',$Email.$Key.$salt);
			$data=array('chiave'=>$chiave);
			Mail::send('emails.invito', $data, function($message) use ($Email,$oggetto)
			{
				$message->to($Email)->subject($oggetto);
			});

			// redirect
			Session::flash('message', 'Invito creato ed inviato con successo!');
			return Redirect::to('admin/invito');
		}
	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$Invito = Invito::find($id);
		$oggetto="Invito ad Intempesta Noctis";
		$Email=$Invito->Email;
		
		$salt="hash_intempesta_noctis";
		$chiave=hash('sha256',$Email.$Invito['Key'].$salt);
		$data=array('chiave'=>$chiave);
		Mail::send('emails.invito', $data, function($message) use ($Email,$oggetto)
		{
			$message->to($Email)->subject($oggetto);
		});

		// redirect
		Session::flash('message', 'Invito reinviato con successo!');
		return Redirect::to('admin/invito');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		
		$Invito = Invito::find($id);
		$Invito -> delete();

		Session::flash('message', 'Invito cancellato correttamente!');
		return Redirect::to('admin/invito');
	}


}
