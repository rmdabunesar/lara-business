@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Get Clarifies</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                        <li class="breadcrumb-item active">Clarifies</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content text-muted bg-white pt-4">
                                <div class="row">
                                    <div class="col-lg-12 col-xl-12">
                                        <div class="card border mb-0">

                                            <div class="card-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <h4 class="card-title mb-0">Get Clarifies</h4>
                                                    </div><!--end col-->
                                                </div>
                                            </div>

                                            <form action="{{ route('update.clarifies') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ optional($clarifies)->id }}">

                                                <div class="card-body">

                                                    <div class="mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" name="title" class="form-control"
                                                            value="{{ old('title', optional($clarifies)->title) }}">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <div class="input-group">
                                                            <input type="text" name="description" class="form-control"
                                                                value="{{ old('description', optional($clarifies)->description) }}">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Image</label>
                                                        <input type="file" name="photo" id="image"
                                                            class="form-control">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label"></label>
                                                        <img src="{{ !empty(optional($clarifies)->image) ? asset(optional($clarifies)->image) : asset('upload/no_image.jpg') }}"
                                                            id="showImage" class="rounded-circle avatar-xxl img-thumbnail"
                                                            alt="Clarifies Image">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Save Changes</button>

                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- Tab panes -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container-fluid -->

    </div>
    <!-- content -->

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#image').change(function(event) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(event.target.files[0]);
                });
            });
        </script>
    @endpush
@endsection
