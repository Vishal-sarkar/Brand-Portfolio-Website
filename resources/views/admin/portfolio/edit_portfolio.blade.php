@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Edit Portfolio</h4>
                        <form action="{{route('update.portfolio')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{$portfolio->id}}">
                            <input type="hidden" name="oldImage" value="{{$portfolio->portfolio_image}}">
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                                <div class="col-sm-10">
                                    <input name="portfolio_name" class="form-control" type="text" value="{{$portfolio->portfolio_name}}"
                                        id="example-text-input">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Short Title</label>
                                <div class="col-sm-10">
                                    <input name="portfolio_title" class="form-control" type="text"
                                        value="{{$portfolio->portfolio_title}}" id="example-text-input">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Long Description</label>
                                <div class="col-sm-10">
                                    <textarea id="elm1" name="portfolio_description">
                                    {{$portfolio->portfolio_description}}
                                    </textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">About Image</label>
                                <div class="col-sm-10">
                                    <input name="portfolio_image" class="form-control" type="file" id="image"
                                        id="example-text-input">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <img class="rounded avatar-lg" id="showImage"
                                        src="{{(!empty($portfolio->portfolio_image))?url($portfolio->portfolio_image):url('upload/no_image.jpg') }}"
                                        alt="Card image cap">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-dark waves-effect waves-light" value="Update Profile">
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#image').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});
</script>



@endsection