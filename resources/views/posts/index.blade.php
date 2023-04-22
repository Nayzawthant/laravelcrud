@extends('layouts.app')
@section('content')
<div class="table-container">
    <div class="search">
        <form method="GET" action="{{ route('posts.index') }}" accept-charset="UTF-8" role="search">
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search..." name="search" value="{{ request('search') }}">
                <button class="search-button">Search</button>
            </div>
        </form>
        @if ($message = Session::get('success'))
            <script>
                const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
                })

                Toast.fire({
                icon: 'success',
                title: '{{ $message }}'
                })
            </script>
        @endif
        <div class="add_post">
            <a href="{{route('posts.create')}}">Add Post</a>
        </div>
    </div>

    
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Image</th>
          <th>Category</th>
          <th>Summary</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (count($posts) > 0)
            @foreach ($posts as $post)
                <tr>
                    <td>{{$post->title}}</td>
                    <td><img src="{{asset('images/' . $post->image)}}" alt="Product A"></td>
                    <td>{{$post->category}}</td>
                    <td>{{$post->summary}}</td>
                    <td>
                    <a href="{{route('posts.edit', $post->id)}}">Edit</a>
                    <form method="post" action="{{ route('posts.destroy', $post->id) }}">
                        @method('delete')
                        @csrf
                        <button onclick="deleteComfirm(event)">Delete</button>
                    </form>
                    
                    </td>
              </tr>
            @endforeach
        @else 
              <p>Post not Found</p>
        @endif
       

      </tbody>
    </table>
    
    <div class="pagination-container">
        {{$posts->links('layouts.pagination')}}
      
    </div>
  </div>
  <script>
    window.deleteComfirm = function (e) {
        e.preventDefault();
        var form = e.target.form;
        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: 'green',
        cancelButtonColor: 'red',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
        })
    }
  </script>
  
@endsection
