<div class="dropdown">
    <button
        type="button"
        class="btn p-0 dropdown-toggle hide-arrow"
        data-bs-toggle="dropdown"
    >
        <i class="bx bx-dots-horizontal-rounded" style="font-size: 30px;"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{route('product.edit', $product->id)}}">
            <i class="bx bx-edit-alt me-1"></i> Edit
        </a>
        <form method="POST" action="{{route('product.delete-product', $product->id)}}" class="d-inline"
              onsubmit="return submitProductDeleteForm(this)">
            @csrf
            @method('delete')
            <button type="submit" class="dropdown-item text-danger">
                <i class="bx bx-trash"></i> Delete
            </button>
        </form>
    </div>
</div>
