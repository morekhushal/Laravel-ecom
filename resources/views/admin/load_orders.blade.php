<table class="table table-hover text-nowrap">
    <thead>
      <tr>
        <th>Sr No.</th>
        <th>Customer</th>
        <th>Product Title</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Order date</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($orders as $key => $order)
          <tr>
              <td>{{ $key+1 }}</td>
              <td>{{ $order->name }}</td>
              <td>{{ $order->product_title }}</td>
              <td>{{ $order->qty }}</td>
              <td>{{ $order->product_price }}</td>
              <td>{{ date('d-M-Y', strtotime($order->created_at)) }}</td>
          </tr>                        
      @empty
          <tr>
              <td colspan="4">No Products found</td>
          </tr>
      @endforelse
    </tbody>
  </table>