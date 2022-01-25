@extends('layouts.app')
@section('styles')
    <style>
        td.actions span {
            display: table-cell !important;
        }

        td.actions span .btn{
            margin-right:5px;
        }
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header  text-right">
                    <h3>Books</h3>
                    <br>{{ __('Dashboard') }}</div>

                    <a class="btn btn-info col-md-2 ml-auto m-3" data-toggle="modal"
                    data-target="#addNewBookModal">
                        <i class="fas fa-plus"></i> Add New Book
                    </a>

                <div class="card-body">
                    {{-- // Create Component --}}
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

                    @if(isset($books))
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Cover</th>
                                <th scope="col">Book Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Price</th>
                                <th scope="col">Published Year</th>
                                <th scope="col">Last Updated</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $book)
                                    <tr>
                                        <td>
                                            @if (Str::contains($book->cover, 'https'))
                                                <img src="{{ $book->cover }}" alt="{{ $book->title }}"
                                                width="100px" height="70px">
                                            @else
                                                <img src="/assets/books/{{ $book->id }}/{{ $book->cover }}"
                                                alt="{{ $book->title }}" width="100px" height="70px">
                                            @endif
                                        </td>
                                        <td scope="row">{{ $book->title }}</td>
                                        <td scope="row">{{ $book->author->name }}</td>
                                        <td>{{ $book->price }}</td>
                                        <td>{{ $book->year_published }}</td>
                                        <td>{{ $book->updated_at }}</td>
                                        <td class="actions">
                                            <span class="mr-3">
                                                <a type="button" class="btn btn-info"  href="{{ URL::to('books/' . $book->id. '/edit') }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </span>
                                            <span class="mr-3">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal{{ $book->id }}" >
                                                    <i class="far fa-trash-alt"></i>
                                                </button>

                                                <div class="modal fade" id="exampleModal{{ $book->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title" id="exampleModalLabel">Alert</h5>
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                                        </div>
                                                        <div class="modal-body">
                                                          Are you sure, You want to delete this Record
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form enctype="multipart/form-data"  method="post" action="{{ route('books.destroy', ['book' => $book->id]) }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Delete</button>
                                                            </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <hr>
                        {!! $books->links() !!}
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNewBookModal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                @component('components.modal.createBook')
                @endcomponent
              </div>
            </div>
        </div>
    </div>
</div>
@endsection
