@extends('admin.admin_master')
@section('admin')

<div class="content">

    <!-- Start Content-->
    <div class="container-xxl">
        <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-18 fw-semibold m-0">All FAQs</h4>
            </div>

            <div class="text-end">
                <ol class="breadcrumb m-0 py-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Components</a></li>
                    <li class="breadcrumb-item active">FAQs</li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ( $faqs as $key=>$item)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->question}}</td>
                                    <td>{{$item->answer}}</td>
                                    <td>
                                        <a href="{{ route('edit.faqs', $item->id) }}" class="btn btn-success btn-sm me-1">Edit</a>
                                        <a href="javascript:void(0);" data-id="{{ $item->id }}" class="btn btn-danger btn-sm delete-faqs">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).on('click', '.delete-faqs', function(e) {
        e.preventDefault();
        var faqsId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (!result.isConfirmed) return;

            $.ajax({
                url: "{{ route('delete.faqs', ':id') }}".replace(':id', faqsId),
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: faqsId
                },
                success: function() {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Faqs has been deleted.',
                        icon: 'success'
                    }).then(() => location.reload());
                }
            });
        });
    });
</script>
@endpush