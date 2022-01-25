<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add New Book</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

    <form enctype="multipart/form-data"  method="POST" action="{{ route('books.store') }}">
        {{ csrf_field() }}
        <div class="modal-body">
            <div class="form-group">
                <label for="bookCover">Cover</label>
                <input type="file" name="cover" class="form-control" id="bookCover">
            </div>
            <div class="form-group">
            <label for="bookTitle">Book Title</label>
            <input type="text" name="title" class="form-control" id="bookTitle"
            placeholder="Enter Book Title">
            </div>
            <div class="form-group">
                <label for="content">Details</label>
                <textarea class="form-control text-left" name="content" id="content" cols="30" rows="10" placeholder="Add Details here">

                </textarea>
            </div>
            <div class="form-group">
                <label for="bookPrice">Price</label>
                <input type="text" class="form-control" name="price" id="bookPrice"
                placeholder="Enter price">
            </div>

            <div class="form-group">
                <label for="yearPublished">Year Published</label>
                <input type="text" class="form-control" name="year_published" id="yearPublished"
                placeholder="Enter Year Published" >
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>




