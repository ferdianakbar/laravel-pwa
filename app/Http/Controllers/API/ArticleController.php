<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $limit = $request->limit ? (int) $request->limit:10;

        $query = Article::select(
            'id', 'title', 'description', 'author', 'created_at'
        );

        $keywords = $request->keywords;
        $query->when($keywords, function ($query) use ($keywords){
            $query->where('title', 'like', '%'.$keywords.'%');
            return $query->orWhere('description', 'like', '%'.$keywords.'%');
        });

        $articles = $query->groupBy('id')->paginate($limit);

        return response()->json(new ArticleCollection($articles));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(),[
            'title' => ['required','string'],
            'description' => ['required', 'string']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $pub_now = $request->publish_now;

        $article = Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'publish_at' => ($pub_now == 1 || $pub_now == true) ? now() : null,
            'author' => $user->id
        ]);

        return new JsonResponse(new ArticleResource($article), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $article = Article::where('id',$id)->first();

        if(!$article) {
            return new JsonResponse([
                'error_message' => 'Not Found'
            ], 404);
        }

        return new JsonResponse(new ArticleResource($article), 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $article = Article::where('id',$id)->first();

        if(!$article) {
            return new JsonResponse([
                'error_message' => 'Not Found'
            ], 404);
        }

        $validator = Validator::make($request->all(),[
            'title' => ['required','string'],
            'description' => ['required', 'string']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $article['title'] = $request->title;
        $article['description'] = $request->description;
        $article['updated_at'] = now();

        $article->save();

        return new JsonResponse(new ArticleResource($article), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $article = Article::where('id',$id)->first();

        if(!$article) {
            return new JsonResponse([
                'error_message' => 'Not Found'
            ], 404);
        }

        $article->delete();

        return new JsonResponse([
            'message' => 'Article with id '. $id .' already deleted'
        ], 200);
    }
}
