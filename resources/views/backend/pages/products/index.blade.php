@extends('backend.layouts.default')
@section('title') Table @parent @endsection

@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Product List</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{url('backend/dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Product</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">

    @if($message = Session::get('success'))
    <div class="alert alert-success m-3" role="alert">
      {{$message}}
    </div>
    @endif

    @if($message = Session::get('updatesuccess'))
    <div class="alert alert-success m-3" role="alert">
      {{$message}}
    </div>
    @endif
    
        <div class="card">
          <div class="card-header">
            <a href="{{route ('products.create')}}"> <button class="btn bg-success">+ Add Product</button></a>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Image</th>
                  <th>Name</th>
                  <th style="width: 40px">Barcode</th>
                  <th >Qty</th>
                  <th >Price</th>
                  <th>Category</th>
                  <th >Status</th>
                  <th ">Manage</th>
                </tr>
              </thead>
              <tbody>
                @foreach($products as $product)
                <tr>
                  <td>{{ ++$i }}</td>  
                 <td> @if(empty($product->product_image))
                  <img src="{{asset('assets/images/noLimg.jpg')}}/{{$product->product_image}}" width="55spx" class="rounded" alt="">
                  @else
                  <img src="{{asset('assets/images/products')}}/{{$product->product_image}}" width="55spx" class="rounded" alt="">
                  @endif
                  </td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->product_barcode}}</td>
                  <td>{{$product->product_qty}}</td>
                  <td>{{$product->product_price}}</td>
                  <td>{{$product->product_category}}</td>
                  <td> {!! config('global.pro_status') [$product->product_status] !!}</td>
                  <td>
                    <form method="POST" action="{{route('products.destroy',$product->id)}}">
                      @csrf
                    <a href="{{route('products.show',$product->id)}}" class="btn btn-info">View</a>
                    <a href="{{route('products.edit',$product->id)}}" class="btn btn-info">Edit</a>
                     @method('DELETE') 
                    <a href="#"><button class="btn btn-info" type="submit" onclick="return confirm('ต้องการลบรายการนี้หรอ')">Delete</button></a>
                
                  </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {{$products->links()}}
          </div>
        </div>
      </section>

  @endsection