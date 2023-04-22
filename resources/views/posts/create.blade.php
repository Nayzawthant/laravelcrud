@extends('layouts.app')
@section('content')
<form method="post" action="{{route('posts.store')}}" enctype="multipart/form-data" >
    @csrf
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <h1>Create Post</h1>
    <div class="form-group">
      <label for="image">Image</label>
      <img src="" alt="" id="file-preview">
      <input type="file" id="image" name="image" accept="image/*" onchange="showFile(event)">
    </div>
    <div class="form-group">
      <label for="title">Title</label>
      <input type="text" id="title" name="title" >
    </div>
    <div class="form-group">
      <label for="category">Category</label>
      <select id="category" name="category" >
        <option value="category1">Choice Category</option>
        @foreach (json_decode('{"Football":"Football","Basketball":"Basketball","Tenis":"Tenis"}', true) as $optionKey => $optionValue)

            <option value="{{$optionKey}}">{{$optionValue}}</option>
        @endforeach 
      </select>
    </div>
    <div class="form-group">
      <label for="summary">Summary</label>
      <textarea id="summary" name="summary" ></textarea>
    </div>
    <div class="form-group">
      <label for="description">Description</label>
      <textarea id="description" name="description" ></textarea>
    </div>
    <button type="submit">Submit</button>
  </form>
  <script>
    function showFile(event) {
        var input = event.target;
        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            var output = document.getElementById('file-preview');
            output.src = dataURL;
        };
        reader.readAsDataURL(input.files[0]);
    }
  </script>
  
@endsection