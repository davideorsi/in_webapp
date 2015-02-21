<?php
use Illuminate\Support\MessageBag;

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	// show the homepage
	public function showHome()
	{
		$max=Famoso::where('1','=','1')->count();
		$randnum=rand(1,$max);
		return View::make('home')
			->with('famoso',$randnum);
	}

	// login form
	public function showLogin()
	{
		// show the form
		return View::make('login');
	}

	// process the login
	public function doLogin()
	{
		// validate the info, create rules for the inputs
		$rules = array(
			'email'  => 'required|email',
			'password' 	=> 'required|min:6' // password can only be alphanumeric and has to be greater than 3 characters
		);

		// run the validation rules on the inputs from the form
		$validator = Validator::make(Input::all(), $rules);

		// if the validator fails, redirect back to the form
		if ($validator->fails()) {
			return Redirect::to('login')
				->withErrors($validator) // send back all errors to the login form
				->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
		} else {

			// create our user data for the authentication
			$userdata = array(
				'email' 	=> Input::get('email'),
				'password' 	=> Input::get('password')
			);

			$remember = Input::get('remember',false);
			
			// attempt to do the login and redirect to User Profile or Admin page depending on the usergroup.
			if (Auth::attempt($userdata,$remember)) {
				
				$USER=Auth::user();
				$id= $USER->id;
				$pg= User::find($id)->PG()->get(array('PG.ID','Nome'));
				if (!empty($pg[0])){
					$idpg=$pg[0]['ID'];
				} else {
					$idpg=false;
				}

				Session::put('idpg', $idpg);

				//redirect to homepage
				return Redirect::to('/');

				
			} else {	 	

				// validation not successful, send back to form
				$errors = new MessageBag(['password' => ['email e/o password  non corretti.']]); 
				return Redirect::to('login')->withErrors($errors);

			}

		}
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('/'); // redirect the user to the login screen
	}
}
