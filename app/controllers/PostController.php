<?php

class PostController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$tags=array(
			'anno'=>'Resoconto Annuale',
			'cronaca'=>'Cronaca',
			'personaggio'=>'Personaggio',
			'descrizione'=>'Descrizione'
		);
		
		$allposts=Post::orderBy('id','asc')->get(array('id','titolo','tag'));

		$posts=array();
		foreach ($allposts as $p){
			$posts[ $tags[$p['tag']] ][ $p['id'] ]=$p['titolo'];
			}
		
		return View::make('post.index')
				->with('posts',$posts);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tags=array(
			'anno'=>'Resoconto Annuale',
			'cronaca'=>'Cronaca',
			'personaggio'=>'Personaggio',
			'descrizione'=>'Descrizione'
		);

		return View::make('post.create')
				->with('tags',$tags);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//regole del validatore
		$rules = array(
			'titolo' => 'required',
			'tag' => 'required',
			'testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/post/create')
				->withErrors($validator);
		} else {
			// store
			$post = new Post;
			$post->titolo 	= Input::get('titolo');
			$post->tag 		= Input::get('tag');
			$post->testo 	= Input::get('testo');
			$post->save();

			// redirect
			Session::flash('message', 'Post creato con successo!');
			return Redirect::to('admin/post');
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($cat,$id)
	{
		$N=Post::where('tag','=',$cat)->count();
		if ($id>$N) {
			$id = ($id-1) % $N +1;
		}
		
		if ($cat == 'personaggio') {
			$orderby='id';
			$order='asc';
		} else {
			$orderby='id';
			$order='desc';
		}
		
		$post=Post::where('tag','=',$cat)->orderBy($orderby,$order)->take(1)->offset($id-1)->get();
		
		$post[0]['N']=$N;

		if ($cat == 'personaggio') {
			$post[0]['testo']=json_decode($post[0]['testo'], true);
		} else {
			$post[0]['testo']=nl2br($post[0]['testo']);
		}
		
		return Response::json($post[0]);	
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tags=array(
			'anno'=>'Resoconto Annuale',
			'cronaca'=>'Cronaca',
			'personaggio'=>'Personaggio',
			'descrizione'=>'Descrizione'
		);

		$post=Post::find($id);

		return View::make('post.edit')
				->with('post',$post)
				->with('tags',$tags);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//regole del validatore
		$rules = array(
			'titolo' => 'required',
			'tag' => 'required',
			'testo' => 'required'
		);
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('admin/post/'.$id.'/edit')
				->withErrors($validator);
		} else {
			// store
			$post = Post::find($id);
			$post->titolo 	= Input::get('titolo');
			$post->tag 		= Input::get('tag');
			$post->testo 	= Input::get('testo');
			$post->save();

			// redirect
			Session::flash('message', 'Post modificato con successo!');
			return Redirect::to('admin/post');
		}
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$post = Post::find($id);
		$post -> delete();

		Session::flash('message', 'Post cancellato correttamente!');
		return Redirect::to('admin/post');
	}


	//#################################################################
	//##	PAGINE DI AMBIENTAZIONE									 ##
	//#################################################################

	public function ambientazione()
	{
		return View::make('ambientazione');

	}
}
