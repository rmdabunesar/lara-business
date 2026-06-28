@extends('admin.admin_master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">Profile</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>

        
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <div class="align-items-center">
                            <div class="d-flex align-items-center">
                                <img 
                                    src="{{ !empty($profileData->photo) 
                                        ? asset('upload/user_images/' . $profileData->photo) 
                                        : asset('upload/no_image.jpg') }}" 
                                    class="rounded-circle avatar-xxl img-thumbnail float-start" 
                                    alt="Profile Image"
                                >

                                <div class="overflow-hidden ms-4">
                                    <h4 class="m-0 text-dark fs-20">{{ $profileData->name }}</h4>
                                    <p class="my-1 text-muted fs-16">{{ $profileData->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content text-muted bg-white pt-4">
                            <div class="row">
                                <div class="col-lg-6 col-xl-6">
                                    <div class="card border mb-0">

                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">                      
                                                    <h4 class="card-title mb-0">Personal Information</h4>                      
                                                </div><!--end col-->                                                       
                                            </div>
                                        </div>
                                        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <div class="card-body">

                                                <div class="mb-3">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ old('name', $profileData->name) }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Email Address</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{ old('email', $profileData->email) }}">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Contact Phone</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="mdi mdi-phone-outline"></i></span>
                                                        <input type="text" name="phone" class="form-control"
                                                            value="{{ old('phone', $profileData->phone) }}">
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <textarea name="address" class="form-control" rows="3">{{ old('address', $profileData->address) }}</textarea>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Profile Image</label>
                                                    <input type="file" name="photo" id="image" class="form-control">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label"></label>
                                                    <img 
                                                        src="{{ !empty($profileData->photo) 
                                                            ? asset('upload/user_images/' . $profileData->photo) 
                                                            : asset('upload/no_image.jpg') }}" 
                                                        id="showImage"
                                                        class="rounded-circle avatar-xxl img-thumbnail" 
                                                        alt="Profile Image"
                                                    >
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Save Changes</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-xl-6">
                                    <div class="card border mb-0">

                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">                      
                                                    <h4 class="card-title mb-0">Change Password</h4>                      
                                                </div><!--end col-->                                                       
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.password.update') }}" method="POST">
                                            @csrf

                                            <div class="card-body mb-0">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Old Password</label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control @error('old_password') is-invalid @enderror" 
                                                            type="password" 
                                                            name="old_password" 
                                                            placeholder="Old Password">
                                                        @error('old_password')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">New Password</label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control @error('new_password') is-invalid @enderror" 
                                                            type="password" 
                                                            name="new_password" 
                                                            placeholder="New Password">
                                                        @error('new_password')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label">Confirm Password</label>
                                                    <div class="col-lg-12 col-xl-12">
                                                        <input class="form-control @error('confirm_password') is-invalid @enderror" 
                                                            type="password" 
                                                            name="confirm_password" 
                                                            placeholder="Confirm Password">
                                                        @error('confirm_password')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-lg-12 col-xl-12">
                                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- Tab panes -->
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