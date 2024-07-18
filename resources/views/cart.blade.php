@extends('user_layout')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('products.index')}}"> Home</a></li>
              <li class="breadcrumb-item active">Cart</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
          <div class="col-6">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ Session::get('success') }}
                </div>
            @elseif(Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ Session::get('error') }}
                </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" id="carts">
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@push('script')
<script>
    $(document).ready(function(){
        
        function loadCart() {
            $.ajax({
                url: 'load-cart',
                type:'GET',
                dataType: "html",
                success:function(response) {
                    $('#carts').html(response);
                }
            })
        }
        loadCart();

        $('body').on('change', '.qty', function(){
            let productId = $(this).data('product_id');
            let qty = $(this).val();
            $.ajax({
                url: 'update-cart-qty',
                type:'POST',
                data:{
                    qty: qty,
                    productId:productId
                },
                dataType: "json",
                success:function(response) {
                    if(response.success == false) {
                        alert(response.message);
                    }
                    loadCart();
                }
            });
        });

        $('body').on('click', '.remove-cart', function(){
            let cartId = $(this).data('cart_id');
            $.ajax({
                url: 'remove-cart',
                type:'POST',
                data:{
                    cartId:cartId
                },
                dataType: "json",
                success:function(response) {
                    if(response.success == false) {
                        alert(response.message);
                    }
                    loadCart();
                }
            });
        });

        
    });
</script>
@endpush