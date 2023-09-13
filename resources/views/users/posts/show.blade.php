@extends('layouts.app')

@section('title','Show Post')

@section('content')
    <div class="row border shadow">
        {{-- LEFT --}}
        <div class="col p-0 border-end">
            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
        </div>
        {{-- RIGHT --}}
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                {{-- header --}}
                <div class="card-header bg-white py-3">
                    <div class="row align-items-center">
                        {{-- image --}}
                        <div class="col-auto">
                            <a href="#">
                                @if($post->user->avatar)
                                    <img src="#" alt="{{$post->user->name}}" class="rounded-circle avatar-sm">
                                @else
                                    <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                @endif
                            </a>
                        </div>
                        {{-- name --}}
                        <div class="col ps-0">
                            <a href="#" class="text-decoration-none text-dark">{{$post->user->name}}</a>
                        </div>

                        {{-- ellipsis --}}
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                {{-- if user is authenticated display EDIT/DELETE menu. Else, display follow/unfollow --}}
                                @if(Auth::user()->id === $post->user->id)
                                    <div class="dropdown-menu">
                                        <a href="{{route('post.edit',$post->id)}}" class="dropdown-item">
                                            <i class="fa-regular fa-pen-to-square"></i>Edit
                                        </a>
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                            <i class="fa-regular fa-trash-can"></i>Delete
                                        </button>
                                    </div>
                                    {{-- include modal here --}}
                                    @include('users.posts.contents.modals.delete')
                                @else
                                    <div class="dropdown-menu">
                                        <form action="#" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- body --}}
                <div class="card-body w-100">
                     {{-- heart button + number of likes + categories --}}
                        <div class="row align-item-center">
                            <div class="col-auto">
                                <form action="#" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm shadow-none p-0">
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                            {{-- count --}}
                            <div class="col-auto px-0">
                                <span>3</span>
                            </div>
                            {{-- category badges --}}
                            <div class="col text-end">
                                @foreach($post->categoryPost as $category_post)
                                <div class="badge bg-secondary bg-opacity-50">
                                    {{$category_post->category->name}}
                                </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- owner + description --}}
                        <a href="#" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
                        &nbsp;
                        <p class="d-inline fw-light">{{$post->description}}</p>
                        <p class="text-uppercase text-muted xsmall">{{$post->created_at->diffForHumans()}}</p>

                        {{-- Include comments here --}}
                </div>
            </div>
        </div>
    </div>
@endsection
