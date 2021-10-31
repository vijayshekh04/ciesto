<?php

namespace App\Http\Controllers;

use App\Product;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['shops'] = Shop::orderBy('id','desc')->get();
        return view('product.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "video"=>"required",
            "shop_id"=>"required",
            "name"=>"required",
            "price"=>"required|numeric|min:1",
            "stock"=>"required|numeric|min:1",
        ],["shop_id.required" => "Shop Name filed is required."]);

        if ($validator->fails())
        {
            return redirect("product/create")
                ->withErrors($validator)
                ->withInput();
        }

        if($request->has("video"))
        {

            if (Product::where(["shop_id"=>$request->shop_id,"name"=>$request->name])->exists())
            {
                Session::flash('product_exists',"Product already exists.");
                return redirect("product/create")
                    ->withInput();
            }

            $input = $request->input();
            unset($input['_token']);
            $destination_path = "storage/uploads/product/";
            $file = $request->file('video');
            $file_name = time().rand().".".$file->getClientOriginalExtension();
            $file->move($destination_path,$file_name);
            $input['video'] = $file_name;
            Product::create($input);

            $request->session()->flash('response',"success");
            $request->session()->flash('msg',"Product Added Successfully.");
            return redirect(url('product'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['shops'] = Shop::orderBy('id','desc')->get();
        $data['product'] = Product::where('id',$id)->first();
        return view('product.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "shop_id"=>"required",
            "name"=>"required",
            "price"=>"required|numeric|min:1",
            "stock"=>"required|numeric|min:1",
        ],["shop_id.required" => "Shop Name filed is required."]);

        if ($validator->fails()){
            return redirect("product/".$id."/edit")
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->input();
        unset($input['_token']);
        unset($input['_method']);

        if ($request->name != $request->old_name)
        {
            if (Product::where(["shop_id"=>$request->shop_id,"name"=>$request->name])->exists())
            {
                Session::flash('product_exists',"Product already exists.");
                return redirect("product/".$id."/edit")
                    ->withInput();
            }
        }

        unset($input['old_name']);
        $product = Product::where('id',$id)->first();
        if($request->has("video"))
        {

            $destination_path = "storage/uploads/product/";
            $exists_path = "storage/uploads/product/".$product->video;
            if (file_exists($exists_path))
            {
                unlink($exists_path);
            }
            $file = $request->file('video');
            $file_name = time().rand().".".$file->getClientOriginalExtension();
            $file->move($destination_path,$file_name);
            $input['video'] = $file_name;
        }
        Product::where('id',$id)->update($input);
        $request->session()->flash('response',"success");
        $request->session()->flash('msg',"Product Updated Successfully.");
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $shop = Product::where('id',$request['id'])->first();

        $exitpath = storage_path('uploads/product/'.$shop->video);
        if (file_exists($exitpath))
        {
            unlink($exitpath);
        }
        Product::where('id',$request['id'])->delete();
        return response()->json(array("status"=>"success","message"=>"Record Deleted Successfully"));
    }

    public function datatable(Request $request)
    {
        $results = Product::with('shop')->orderBy('id','desc')->get();
        return DataTables::of($results)
            ->addColumn('action',function ($results){
                return '<div class="text-center">
                         <a href="'.route('product.edit',$results->id).'"  title="Edit" class="text-warning fa-lg"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                         <a href="javascript:void(0)" data-id="'.$results->id.'" class="delete_btn text-danger fa-lg"  title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>';
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
