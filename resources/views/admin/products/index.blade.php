@extends('layouts.app')
@section('title')
    {{__('All Products')}}
@endsection

@section('datatable_style')
    @include('partials.datatable_styles')
@endsection

@section('breadcrumb')
    <h6 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Products /</span> list</h6>
@endsection

@section('dashboard')
    active
@endsection

@section('content')
    {{--  search  --}}
    <div class="col-12">
        @include('admin.products.partials._product_search_form')
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">All Product</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-5 float-end">
                        <a
                            class="btn btn-primary"
                            href="{{ route('product.create') }}"
                        >
                            <i class="bx bx-plus"></i> Add a product
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                @include('admin.products.partials._table')
            </div>
        </div>
    </div>
@endsection

@section('datatable_script')
    @include('partials.datatable_script')
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            var productTable = $('#product_table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: true,
                ajax: {
                    url: "{{ route('product.get-products') }}",
                    data: function (data) {
                        data.search_text = $('#search_text').val();
                        data.sort_by = $('#sort_by').val();
                    }
                },
                columns: [
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'code',
                        name: 'code',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'category',
                        name: 'category',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'special_price',
                        name: 'special_price',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#sort_by').on('change', function () {
                productTable.draw();
            });
            $('#search_text').on('keyup', function () {
                productTable.draw();
            });
        });

        function submitProductDeleteForm(form) {
            new Swal({
                title: "Are you sure?",
                text: "to delete this product ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes Delete",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            return false;
        }
    </script>
@endsection
