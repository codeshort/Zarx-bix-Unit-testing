@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Books</h3>
                    <br>{{ __('Dashboard') }}</div>
                    @if (session('success'))
                        <div class="alert alert-success m-3" role="alert">
                            {{ session('success') }}
                        </div>
                    @else
                        @if (session('error'))
                            <div class="alert alert-danger m-3" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                <div class="card-body">
                    @if(isset($book))
                    <form enctype="multipart/form-data"  method="POST" action="{{ route('books.update', ['book' => $book->id]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="bookCover">Cover</label>
                            <input type="file" name="cover" class="form-control" id="bookCover" aria-describedby="emailHelp">
                          </div>
                        <div class="form-group">
                          <label for="bookTitle">Book Title</label>
                          <input type="text" name="title" class="form-control" id="bookTitle" aria-describedby="emailHelp"
                          placeholder="Enter Book Title" value="{{ $book->title }}">
                        </div>
                        <div class="form-group">
                            <label for="content">Details</label>
                            <textarea class="form-control text-left" name="content" id="content" cols="30" rows="10">
                                {!! $book->content !!}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="bookPrice">Price</label>
                            <input type="text" class="form-control" name="price" id="bookPrice" aria-describedby="emailHelp"
                            placeholder="Enter price" value="{{ $book->price }}">
                        </div>

                        <div class="form-group">
                            <label for="yearPublished">Year Published</label>
                            <input type="text" class="form-control" name="year_published" id="yearPublished" aria-describedby="emailHelp"
                            placeholder="Enter Year Published" value="{{ $book->year_published }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a class="btn btn-primary" href="{{ url()->previous() }}">Back</a>
                      </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $( document ).ready(function() {
            function showEditField(fieldId){
                $("#row"+fieldId).fadeIn(300);
            };
        });
    </script>
@endsection
