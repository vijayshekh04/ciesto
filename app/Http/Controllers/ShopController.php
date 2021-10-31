<?php

namespace App\Http\Controllers;

use App\Product;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
    use Illuminate\Support\Faceds\File;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //return public_path('uploads/shop/no-image.png');
        return view('shop.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shop.add');
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
            "image"=>"required|mimes:jpeg,jpg,png",
            "name"=>"required|unique:shops,name",
            "email"=>"required|email",
            "address"=>"required",
        ]);

        if ($validator->fails())
        {
            return redirect("shop/create")
                ->withErrors($validator)
                ->withInput();
        }

        if($request->has("image"))
        {
            $input = $request->input();
            unset($input['_token']);
            $destination_path = "storage/uploads/shop/";
            if(!File::isDirectory($destination_path)){

                File::makeDirectory($destination_path, 0777, true, true);
            }
            $file = $request->file('image');
            $file_name = time().rand().".".$file->getClientOriginalExtension();
            $file->move($destination_path,$file_name);
            $input['image'] = $file_name;
            Shop::create($input);

            $request->session()->flash('response',"success");
            $request->session()->flash('msg',"Shop Added Successfully.");
            return redirect(url('shop'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['shop'] = Shop::where('id',$id)->first();
        return view('shop.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "image"=>"nullable|mimes:jpeg,jpg,png",
            "name"=>"required|unique:shops,name",
            "email"=>"required|email",
            "address"=>"required",
        ]);

        if ($validator->fails()){
            return redirect("shop/".$id."/edit")
                ->withErrors($validator)
                ->withInput();
        }

        $input = $request->input();
        unset($input['_token']);
        unset($input['_method']);
        $shop = Shop::where('id',$id)->first();
        if($request->has("image"))
        {
            request()->validate([
                "file"=>"mimes:jpeg,jpg,png",
            ]);
            $destination_path = "storage/uploads/shop/";
            if(!File::isDirectory($destination_path)){

                File::makeDirectory($destination_path, 0777, true, true);
            }
            $exists_path = "storage/uploads/shop/".$shop->image;
            if ($shop->image != "no-image.png")
            {
                unlink($exists_path);
            }
            $file = $request->file('image');
            $file_name = time().rand().".".$file->getClientOriginalExtension();
            $file->move($destination_path,$file_name);
            $input['image'] = $file_name;
        }
        Shop::where('id',$id)->update($input);
        $request->session()->flash('response',"success");
        $request->session()->flash('msg',"Shop Updated Successfully.");
        return redirect('shop');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $shop = Shop::where('id',$request['id'])->first();

        if ($shop->image != "no-image.png")
        {
            $exitpath = storage_path('uploads/shop/'.$shop->image);
            if ($exitpath)
            {
                unlink($exitpath);
            }
        }
        Product::where('shop_id',$request['id'])->delete();
        Shop::where('id',$request['id'])->delete();
        return response()->json(array("status"=>"success","message"=>"Record Deleted Successfully"));
    }

    public function datatable(Request $request)
    {
        $results = Shop::orderBy('id','desc')->get();
        return DataTables::of($results)
            ->editColumn('image',function ($results){
                return '<img src="'.asset('storage/uploads/shop/'.$results->image).'" height="100px">';
            })
            ->addColumn('action',function ($results){
                return '<div class="text-center">
                         <a href="'.route('shop.edit',$results->id).'"  title="Edit" class="text-warning fa-lg"><i class="fa fa-pencil" aria-hidden="true"></i></i></a>
                         <a href="javascript:void(0)" data-id="'.$results->id.'" class="delete_btn text-danger fa-lg"  title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>';
            })
            ->escapeColumns(['*'])
            ->make(true);
    }
}
