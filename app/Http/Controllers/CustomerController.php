<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer; //tinawag via model
use Illuminate\Support\Facades\View; //ginagamit ito para tawagin extension na ito
use Illuminate\Support\Facades\Validator;// same dito
use Illuminate\Support\Facades\Redirect;// and dito
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        // $customers = Customer::orderBy('id','DESC')->get();
        // $customers = Customer::orderBy('id','DESC')->paginate(10);  //Paginate 1 pag 2 na lilipat na agad sa isa 
        $customers = Customer::withTrashed()->orderBy('customer_id','DESC')->paginate(1); 
        // dd($customers);
        return view("customer.index", [ 
            "customers" => $customers, 
        ]); 
       // return View::make('customer.index',compact('customer')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('customer.create'); 
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $rules = [  'title' =>'required|alpha_num|min:3',
                    'lname'=>'required|alpha',
                    'fname'=>'required',
                    'address'=>'required',
                    'phone'=>'numeric',
                    'town'=>'required',
                    'zipcode'=>'required'];
        
        $validator = Validator::make($request->all(), $rules); 
        
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
       
        }
            Customer::create($request->all());
            return Redirect::to('customer')->with('success','New Customer added!');

            $path = Storage::putFileAs('images/customer', $request->file('image'),$request->file('image')->getClientOriginalName());
        //storage folder na sya mapupunta hindi na public
        
            // dd($path);
        
            $request->merge(["img_path"=>$request->file('image')->getClientOriginalName()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id); 
        return view('customer.edit',compact('customer'));  
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
        // $customer = Customer::find($id);
        // // dd($customer);
        // $customer->update($request->all());
        // return Redirect::to('/customer')->with('success','Customer updated!');

        $customer = Customer::find($id); //alam mo toh diba?oo
         $validator = Validator::make($request->all(), Customer::$rules, Customer::$messages); //eh ito gets?oo

          if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
       
        }
            $customer->update($request->all());
            return Redirect::to('customer')->with('success','New Customer Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id); //ito gets mo?oo
        $customer->delete();
        return Redirect::to('customer')->with('success','Customer deleted!');
    }
    public function restore($id) {

        Customer::onlyTrashed()->findOrFail($id)->restore(); //OnlyTrashed basura lang pwede
        return  Redirect::route('customer.index')->with('success','customer restored successfully!');
    }
        //OnlyTrashed - dinelete lang makikita WithTrashed = Kasama dinelete at di dineelte makikita WithoutTrashed = Yung di dinelete lang makikita
    public function forceDelete($customer_id)
    { //Redirect::route = PAra ikaw maglagay kung saan mo gusto pupunta for example customer.index / update or edit yan
        //Redirect::to = Default nyan is customer or customer.index pag nilagay mo customer.index error dahil default na ang pupuntahan 
        Customer::withTrashed()
            ->findOrFail($customer_id)
            ->forceDelete(); //so hulaan mo ginagawa neto delete panung delete boset ka talaga HAHAHA HSAHHAS di na marerestore?TAMA wow wow magic
        return Redirect::route("customer.index")->with(
            "success",
            "customer Permanently Deleted!" //ay madaya may kodigo ay di ko nabasa yann hmm HAHAH charot
        );
    }
}


