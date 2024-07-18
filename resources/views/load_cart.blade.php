<form action="{{ route('place-order') }}" method="POST">
    @csrf
    @php $grandTotal=0; @endphp
<table class="table table-hover text-nowrap">
    <thead>
      <tr>
        <th>Sr No.</th>
        <th>Title</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($carts as $key => $cart)
          <tr>
              <td>{{ $key+1 }} </td>
              <td>{{ $cart->product->title }}</td>
              <td><input type="number" class='qty' data-product_id="{{ $cart->product->id }}" name="quantity" min="1"  value="{{ $cart->qty }}"> </td>
              <td>{{ $cart->product->price }}&#x20b9;</td>
              <td>{{ $cart->product->price * $cart->qty }}&#x20b9;</td>
              <td>
                @php $grandTotal+=($cart->product->price * $cart->qty) @endphp
                <a href="#" class='remove-cart' data-cart_id="{{ $cart->id }}" ><span class="fas fa-trash text-danger"></span></a>
                   {{--  
                  <form style="display: inline-block" action="{{ route('carts.destroy', $cart->id) }}" method="post" onsubmit="return confirm('Are you sure to delete this product?')">
                      @csrf
                      @method('DELETE')
                      <a href="#" onclick="this.closest('form').submit()"><span class="fas fa-trash text-danger"></span></a>
                  </form> --}}
              </td>
          </tr>                        
      @empty
          <tr>
              <td colspan="5">No Products found</td>
          </tr>
      @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Grand Total</td>
            <td>{{ $grandTotal }}&#x20b9;</td>
            <td>
                <button type="submit" class="btn btn-success">Place Order</button>
            </td>
        </tr>
        
    </tfoot>
  </table>
</form>