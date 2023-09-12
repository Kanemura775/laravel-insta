<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    //
    private $post;
    private $category;

    public function __construct(Post $post, Category $category)
    {
        $this->post = $post;
        $this->category = $category;
    }

    public function create()
    {
        $all_categories = $this->category->all();

        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request)
    {
        //dd($request); //die and debug
        //#1 varidate
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);
        //dd('hi');

        //#2 save the new entries in to the posts table
        $this->post->user_id = Auth::user()->id;
        $this->post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save();
        //#3 save the new entries in to the pivot table(category_post)
        /**
         * SIMLATE:
         * intial state
         * $category_post = []
         * user selected Travel = category->id = 1, Food = category->id = 2
         *
         * ITR #1:
         *   $category_post = [
         *      'category_id' => 1
         *    ]
         *
         * ITR #2:
         *  $category_post = [
         *      'category_id' => 1,
         *      'category_id' => 2
         *    ]
         */
        foreach ($request->category as $category_id) {
            $category_post[] = [
                'category_id' => $category_id
            ];
        }

        $this->post->categoryPost()->createMany($category_post);

        return redirect()->route('index');
    }
}
