@extends('layouts.app')
@section('title')
    {{__('Create Product')}}
@endsection

@section('breadcrumb')
    <h6 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Product /</span> create</h6>
@endsection

@section('dashboard')
    active
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Create new product</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('product.store') }}" method="post" id="product_create_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="code">Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="code" name="code" required
                                   placeholder="Product Code" minlength="10" maxlength="10"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required
                                   placeholder="Product Name"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="selling_price">Selling Price <span class="text-danger">*</span></label>
                            <input
                                type="number"
                                id="selling_price"
                                name="selling_price"
                                class="form-control"
                                placeholder="Selling Price"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label d-block">Is Delivery Available</label>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="is_delivery_available" id="is_delivery_available1" value="1" checked>
                                <label class="form-check-label" for="is_delivery_available1">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="is_delivery_available" id="is_delivery_available2" value="0">
                                <label class="form-check-label" for="is_delivery_available2">No</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="category">Category <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="category" name="category" required
                                   placeholder="Product Category"/>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="out_of_stock">Out of Stock</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="special_price">Special Price</label>
                            <input
                                type="number"
                                id="special_price"
                                name="special_price"
                                class="form-control"
                                placeholder="Special Price"
                            />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-3">
                <h5>Attributes</h5>

                <div class="row">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <small class="text-muted float-end"></small>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="attribute_name">Attribute Name</label>
                                            <input type="text" class="form-control" name="attribute_name[]" id="attribute_name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label" for="attribute_value">Attribute Value</label>
                                            <input type="text" class="form-control" id="attribute_value" name="attribute_value[]"/>
                                        </div>
                                    </div>
                                </div>
                                <div id="add_more_attribute"></div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-info float-end" id="btn_add_attribute"><i
                                    class="bx bx-plus"></i> add more
                                attribute
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="product_save_btn">Save</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            ///////////////////////////////////////////////////
            //submit edit form
            $('#product_save_btn').on('click', function (e) {
                $(this).attr('disabled', true);
                let form = document.querySelector("#product_create_form");
                e.preventDefault();
                form.submit();
                new Swal({
                    title: "Please wait...",
                    text: "product is being saving....",
                    imageUrl: "{{ url('assets/img/ajax-loader.gif') }}",
                    buttons: false,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    isDismissed: false,
                    showConfirmButton: false
                });
            });

            $(document).on('click', '#btn_add_attribute', function () {
                var html = '';
                html += '<div class="row more-attribute">';
                html += '<div class="col-md-6">';
                html += '<div class="mb-3">';
                html += '<input type="text" class="form-control" name="attribute_name[]">';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-4">';
                html += '<div class="mb-3">';
                html += '<input type="number" class="form-control" name="attribute_value[]"/>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-2">';
                html += '<div class="mb-3 pt-2">';
                html += '<button type="button" name="remove-pro" class="btn btn-danger btn-sm remove"><span class="bx bx-trash"></span> Remove</button>';
                html += '</div>';
                html += '</div>';
                html += '</div>';

                $('#add_more_attribute').append(html);
            });

            $(document).on('click', '.remove', function () {
                $(this).closest('.more-attribute').remove();
            });

        });
    </script>
@endsection
