@if($product->status == 'draft')
    <label class="form-label bg-label-warning p-1 rounded px-3">Draft</label>
@elseif($product->status == 'published')
    <label class="form-label bg-label-success p-1 rounded px-3">Published</label>
@elseif($product->status == 'out_of_stock')
    <label class="form-label bg-label-danger p-1 rounded px-3">Out of Stock</label>
@endif
