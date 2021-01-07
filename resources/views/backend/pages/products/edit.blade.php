@extends('backend.layouts.default')
@section('title') Edit @parent @endsection
@section('content')
            <!-- general form elements -->
          <section class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">
                    <h1>Edit Product</h1>
                  </div>
                  <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{route('products.index')}}">Product list</a></li>
                      <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>
        
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
              <div class="card-header">
              <h3 class="card-title">เเก้ไขรายการสินค้า</h3>
              </div>

              <!--นำค่ามาเเสดงเมื่อกดเพิ่มข้อมูลเเล้ว เมื่อรีเฟชเเล้วจะหายไปเป็น Session ชั่วคราว-->
              @if($message = Session::get('success'))
              <div class="alert alert-success m-3" role="alert">
                {{$message}}
              </div>
              @endif
              
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" action="{{route('products.update',$product->id)}}">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-10">
                  <div class="form-group">
                    <label for="exampleInputEmail1">ชื่อสินค้า</label>
                    <input type="text" class="form-control" id="exampleInputEmail1"  name="product_name" placeholder="ป้อนชื่อสินค้า" value="{{$product->product_name}}">
         
                  </div>
                  <div class="form-group">
                    <label for="product_detail">รายละเอียด</label>
                    <textarea class="form-control" id="product_detail" name="product_detail"  style="height: 100px" value="{{$product->product_detail}}"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">บาร์โค้ด</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="product_barcode"  placeholder="ป้อนบาร์โค้ด" value="{{$product->product_barcode}}">
                   
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">จำนวนชิ้น</label>
                    <input type="text" class="form-control" id="exampleInputPassword1"  name="product_qty" placeholder="ป้อนจำนวนชิ้น" value="{{$product->product_qty}}">
        
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">ราคา</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="product_price" placeholder="ป้อนราคา" value="{{$product->product_price}}">
                   
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">หมวดหมู่</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="product_category" placeholder="ป้อนหมวดหมู่" value="{{$product->product_category}}">
               
                  </div>
                  <div class="form-group">
                    <label for="inputStatus">สถานะสินค้า</label>
                    <select class="form-control custom-select" name="product_status">
                      <option selected disabled>Select one</option>
                      <option value="1" @if($product->product_status == 1) selected @endif>In stock</option>
                      <option value="0" @if($product->product_status == 0) selected @endif>Out stock</option>
                    </select>
                  </div>
                </div>
            
                
                  <div class="col-md-2">
                    <div class="form-group">
                            <label for="product_image">ภาพสินค้า</label>
                            @if(empty($product->product_image))
                            <img src="{{asset('assets/images/noLimg.jpg')}}/{{$product->product_image}}"  class="rounded img-fluid rounded" alt="">
                            @else
                            <img src="{{asset('assets/images/products')}}/{{$product->product_image}}" class="rounded img-fluid rounded" alt="">
                            @endif
                          
                            <span class="btn btn-primary btn-file my-2">
                                เลือกไฟล์ <input type="file" name="product_image" id="product_image" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                            </span>
                            <p class="label-uppic">เลือกภาพสินค้า</p>
                      </div>
                </div>  
              </div>
                </div>
              
                  
                <!-- /.card-body -->

                <div class="card-footer text-center">
                  <button type="submit" class="btn btn-primary">บันทึกรายการ</button>
                </div>
              </form>
           
          </div>
          </div>
        </section>

 @endsection