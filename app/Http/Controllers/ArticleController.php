<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Articles;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //set to article model that we are going to create and in descending order
        $articles = Articles::orderBy('created_at','desc')->paginate(5);
        //return the collection of articles of resurce we gottsa bring in
        return ArticleResource::collection($articles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create a url that has an id attached to it else a new article
        $article = $request->isMethod('put') ? Articles::findOrFail($request->article_id) : new Articles;

        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article->save()){
            return new ArticleResource($articles);
  
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get a single article this would appear on the url
        $article = Articles::findOrFail($id);

        //return a single article as a resource
        return new ArticleResource($article);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //get a single article this would appear on the url
        $article = Articles::findOrFail($id);

       if ($article->delete()) {
            //return a single article as a resource
        return new ArticleResource($article);
       }
    }
}
