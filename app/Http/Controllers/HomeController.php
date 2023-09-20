<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    //get the users that the auth user is not following
    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user) {
            if (!$user->isfollowed()) {
                $suggested_users[] = $user;
            }
        }
        /**
         * INITIAL STATE:
         * $all_user
         * USERS TABLE
         * 1 (login user) (EXCEPT: except(Auth::user()->id);)
         * 2
         * 3
         *
         * FOLLOWS TABLE
         * follower_id   | Following_id
         *      1             2
         *      2             3
         *      2             1
         *
         * $suggested_users = [];
         *
         * LOOP
         * ITR #1 user 2
         * CONDITION  =  if(!$user->isFollowed())
         * RESULT = !TRUE = FALSE
         * $suggested_users = [];
         *
         *  ITR #2 user 3
         * CONDITION  =  if(!$user->isFollowed())
         * RESULT = !FALSE = TRUE
         * $suggested_users = [3];
         */
        return $suggested_users;
    }


    private function getHomePost()
    {
        $all_posts = $this->post->latest()->get();
        $home_posts = [];

        foreach ($all_posts as $post) {
            if ($post->user->isFollowed() || $post->user->id === Auth::user()->id) {
                $home_posts[] = $post;
            }
        }
        return $home_posts;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        $all_posts = $this->getHomePost();
        $suggested_users = $this->getSuggestedUsers();

        return view('users.home')
            ->with('all_posts', $all_posts)
            ->with('suggested_users', $suggested_users);
    }
}
