<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;
use Validator;// Class ตรวจสอบข้อมูลในฟอมร์

// โหลด Library จัดการรูป
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //อ่านข้อมูล          //ดึงข้อมูลล่าสุด  //เเบ่งหน้าละ 10
        $products = Product::latest()->paginate(2);
        // print_r($products);
        return view('backend.pages.products.index',compact('products'))->with('i',(request()->input('page',1)-1)*2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('backend.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        print_r($request->all());
        
        $rules = [
            'product_name' => 'required',
            'product_barcode'  => 'required|integer|digits:13|unique:products',
            'product_qty' => 'required',
            'product_price'=> 'required',
            'product_category' => 'required'


        ];
            $message = [
            'required' => 'จำเป็นต้องกรอก',
            'integer' => 'ใส่เป็นตัวเลขเท่านั้น',
            'digits'=>'ต้องเป็นตัวเลขความยาว:digits หลัก',
            'unique'=>'barcode ซ้ำกับในระบบ'
            ];

            $validator = Validator::make($request->all(),$rules,$message );
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }else{
                $product_data = array(
                    'product_name' => $request->product_name,
                    'product_barcode' => $request->product_barcode,
                    'product_detail' => $request->produc_detail,
                    'product_qty' => $request->product_qty,
                    'product_price' => $request->product_price,
                    'product_category' => $request->product_category,
                    'product_status' => $request->product_status
                );
                
                //Uploade Image 
                try{
                    $image = $request->file('product_image');                    
                    //เช็คว่ามีการเลือกไฟล์ภาพหรือไหม
                    if(!empty($image)){
                        //เปลี่ยนชื่อรุปไม่ให้ซ้ำกับคนอื่น
                        $file_name = "product_".time().".".$image->getClientOriginalExtension();
                        //กำหนดประเภทไฟล์รุป
                        if($image->getClientOriginalExtension() == "jpg" or $image->getClientOriginalExtension() == "png"){
                            //กำหนดขนาดรูป
                            $imgWidth = 300;
                            //พาทรูป
                            $folderupload = "assets/images/products";
                            $path = $folderupload ."/".$file_name;

                            //upload เข้าโฟลเดอร์ Products
                            $img = Image::make($image->getRealPath());
                            //เช็ค ขนาดรูปก่อนเข้าโฟลเดอร์ ถ้าขนาดไม่ตาม 300 ก็จะรีไซต์
                            if($img->width() > $imgWidth){
                                $img->resize($imgWidth, null, function($constraint){
                                    $constraint->aspectRatio();
                                });
                            }
                            //เซฟรุปเข้าโฟลเดอร์
                            $img->save($path);
                            $product_data['product_image'] = $file_name;

                        }else{
                            //เเจ้งเตือนหน้า view เมื่อไม่ใช่ไฟล์รูป
                            return redirect()->route('products.create')->withErrors($validator)->withInput()->with('status','<div class="alert alert-danger">ไฟล์ภาพไม่รองรับ ใช้ได้ jpg กับ png เท่านั้น </div>');
                        }
                    }
                }catch(Exception $e){
                    print_r($e);
                    //return false;
                }

                Product::create($product_data);
                return redirect()->route('products.create')->with('success','เพิ่มสินค้าเรียบร้อยเเล้ว');
          
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('backend.pages.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
        return view('backend.pages.products.edit',compact('product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
     {

        $product_data = array(
            'product_name' => $request->product_name,
            'product_detail' => $request->product_detail,
            'product_barcode' => $request->product_barcode,
            'product_qty' => $request->product_qty,
            'product_price' => $request->product_price,
            'product_category' => $request->product_category,
            'product_status' => $request->product_status,
            'updated_at' => NOW()
        );

         // Upload Product Image
         try{
            $image = $request->file('product_image');
            // เช็คว่ามีการเลือกไฟล์ภาพเข้ามาหรือไม่
            if(!empty($image)){
                $file_name = "product_".time().".".$image->getClientOriginalExtension();
                if($image->getClientOriginalExtension() == "jpg" or $image->getClientOriginalExtension() == "png"){
                   
                    $imgWidth = 300;
                    $folderupload = "assets/images/products";
                    $path = $folderupload."/".$file_name;

                    // upload to folder products
                    $img = Image::make($image->getRealPath());

                    if($img->width() > $imgWidth){
                        $img->resize($imgWidth, null, function($constraint){
                            $constraint->aspectRatio();
                        });
                    }

                    $img->save($path);
                    $product_data['product_image'] = $file_name;
                }else{
                    return redirect()->route('products.create')->withErrors($validator)->withInput()->with('status','<div class="alert alert-danger">ไฟล์ภาพไม่รองรับ อนุญาติเฉพาะ .jpg และ .png</div>');
                }
            }
        }catch(Exception $e){
            print_r($e);
            return false;
        }

        $product->update($request->all());

        return redirect()->route('products.index')->with('success','เเก้ไขเรียบร้อยเเล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('updatesuccess','ลบสินค้าเรียบร้อยเเล้ว');
    }
}
