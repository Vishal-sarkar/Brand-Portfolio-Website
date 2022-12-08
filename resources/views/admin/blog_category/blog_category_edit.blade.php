@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                    <h4 class="card-title">Portfolio Page</h4>
                        <form action="{{route('update.blog.category',$blogCategory->id)}}" method="post">
                            @csrf
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Protfolio Name</label>
                                <div class="col-sm-10">
                                    <input name="blog_category" class="form-control" type="text"
                                        id="example-text-input" value="{{$blogCategory->blog_category}}">
                                    @error('blog_category')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            
                            <input type="submit" class="btn btn-dark waves-effect waves-light" value="Insert Blog Category">
                        </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>




@endsection