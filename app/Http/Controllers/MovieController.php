<?php

namespace Cinema\Http\Controllers;

use Illuminate\Http\Request;

use Cinema\Http\Requests;
use Cinema\Http\Controllers\Controller;
use Cinema\Genre;
use Cinema\Movie;
use Session;
use Redirect;
use Auth;
use Illuminate\Routing\Route;

class MovieController extends Controller
{
    //

  public function __construct(){
      $this->middleware('auth');
      $this->middleware('admin',['only'=>['create','edit']]);
      //$this->middleware('@find', ['only' => ['edit','update','destroy']]);
//      $this->beforeFilter('@find',['only'=>['edit','update','destroy']]);
  }

	public function index(){
		$movies = Movie::Movies();
		return view('pelicula.index', compact('movies'));
	}

  public function find(Route $route){
      $this->movie = Movie::find($route->getParameter('pelicula'));
  }

	public function create(){

		$genres = Genre::lists('genre','id');
		return view('pelicula.create', compact('genres'));
	}

   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
      Movie::create($request->all());
      return "Listo";
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genres = Genre::lists('genre', 'id');
				$movie = Movie::find($id);
        return view('pelicula.edit',['movie'=>$movie,'genres'=>$genres]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


				$movie = Movie::find($id);
        $movie->fill($request->all());
        $movie->save();

        Session::flash('message','Pelicula Editada Correctamente');
        return Redirect::to('/pelicula');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::destroy($id);
        $movie->delete();
        \Storage::delete($movie->path);
        Session::flash('message','Pelicula Eliminada Correctamente');
        return Redirect::to('/pelicula');
    }  

}
