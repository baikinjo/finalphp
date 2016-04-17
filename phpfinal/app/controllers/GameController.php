<?php

class GameController extends \BaseController {
	
	protected $gamer;

	public function __construct(Game $gamer){
		$this->game = $gamer;
	}
	
	public function index()
	{
		return View::make('game.index');
	}


	public function play()
	{
		return View::make('game.game');
	}
	
	public function result()
	{
		return View::make('game.result', ['games'=>$this->game->all()]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();

		$this->game->fill($input);

		$this->game->username = Input::get('username');
		$this->game->score = Session::get('score');
		$this->game->streak = Session::get('streak');
		$this->game->save();


		return View::make('game.result', ['games'=>$this->game->all()]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
