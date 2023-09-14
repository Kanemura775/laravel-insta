{{-- clickable image --}}
<div class="container p-0">
    <a href="{{route('post.show',$post->id)}}">
        <img src="{{$post->image}}" alt="post id{{$post->id}}" class="w-100">
    </a>
</div>

<div class="card-body">
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
    @include('users.posts.contents.comments')
</div>
