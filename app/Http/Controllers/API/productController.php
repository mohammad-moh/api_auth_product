<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\baseController as baseController;
use App\Http\Resources\ProductResource;
use App\Models\product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class productController extends baseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=product::all();
        return $this->responseData(ProductResource::collection($products), 
                    'Products retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input= $request->all();
        $validator= Validator::make($request->all(),[
            'name'=> 'required',
            'price'=> 'required',
        ]);
        if($validator->fails())
        {
            return $this->errorResponse('Validation Error.', $validator->errors()); 
        }
        
        $product= product::create($input);
        return $this->responseData(new ProductResource($product), 'Validation Success');       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=product::find($id);
        if($product){
            return $this->responseData(new ProductResource($product), "Successfully get product");
        }else
        {
            return "This Product is Not Found"; 
        }
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product= product::find($id);
        $validator=Validator::make($request->all(),
                [
                    'name'=> 'required',
                    'price'=> 'required'            
                ]
        );

        if($validator->fails()){
            return $this->errorResponse("Updated Error", $validator->errors());
        }
        if($product){
            $product->update($request->all());       
            $product->save();      
            return $this->responseData(new ProductResource($product), "Product Updated succefully");        
        }else{
            return "This product Not Found";
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=product::find($id);
        if($product){
            $product->delete();       
            return $this->responseData([],'Deleted Done Successfully.');
        }else{
            return "This product is Not Found";
        }
       
    }
}