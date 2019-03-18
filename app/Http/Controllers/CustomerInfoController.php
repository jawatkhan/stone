<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Client;
use Auth;
use App\Product;
use App\Invoice;
use App\Libraries\Library;
use DB;

class CustomerInfoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Client::orderBy('org_name')->where('user_id','=',Auth::user()->author_id)->where('typeOfClient','=','Customer')->get();
        return view('dashboard/customer_info/index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Client::orderBy('org_name','asc')->where('user_id','=',Auth::user()->author_id)->where('typeOfClient','=','Customer')->pluck('org_name','id');
        return view('dashboard/customer_info/create',compact('customers'));
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
            'customer_org_name' => 'required|string',
            'customer_address' => 'required|string|max:255',
            'customer_email' => 'email|max:50|nullable',
            'customer_contact_no' => 'string|max:11|required|regex:/^[১২৩৪৫৬৭৮৯০0-9]/',
        ]);
        if ($validator->passes()) {

            DB::beginTransaction();
            $bangla = array(
                    'customer_contact_no' => $request->customer_contact_no,
                );
            $english = Library::bn2en($bangla);
            $client = new Client;
            $client->user_id      = Auth::user()->author_id;
            $client->posting_author_id      = Auth::user()->id;
            $client->org_name      = $request->customer_org_name;
            $client->address       = $request->customer_address;
            $client->email         = $request->customer_email;
            $client->contact_no    = $english['customer_contact_no'];
            $client->typeOfClient  = 'Customer';
            $client->save();

            $invIdQu = Product::orderBy('created_at','dsc')->where('products.user_id','=',Auth::user()->author_id)->where('products.typeOfProduct','=','Customer')->first();
            
            if(empty($invIdQu)){

                $invoice_number = 1;
            }else{
                $proInvoiceList = Invoice::find($invIdQu->invoice_id);
                $invoice_number = $proInvoiceList->invoice_no + 1;
            }
            $datas = new Invoice;
            $datas->invoice_no = $invoice_number;
            $datas->save();

            DB::commit();

            $encode_id = base64_encode($datas->id);
            $encode_client_id = base64_encode($client->id);
            return Response::json(['success' => '1','client_id'=>$encode_client_id,'id'=>$encode_id]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function deleteSellerinfo(Request $request)
    {
        $del = Client::find($request->id);
        $del->delete();
        return Response()->json(['success'=>'1']);
    }

    public function editseller(Request $request)
    {
        $data = Client::find($request->id);
        return Response()->json($data);
    }
    public function updateSeller(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'new_org_name' => 'required|string',
            'seller_address' => 'required|string|max:255',
            'seller_email' => 'email|max:50|nullable',
            'seller_contact_no' => 'string|max:11|required|regex:/^[১২৩৪৫৬৭৮৯০0-9]/',
        ]);
        if ($validator->passes()) {
            $bangla = array(
                    'customer_contact_no' => $request->customer_contact_no,
                );
            $english = Library::bn2en($bangla);
            $client = Client::find($request->client_id);
            $client->org_name      = $request->new_org_name;
            $client->address       = $request->seller_address;
            $client->email         = $request->seller_email;
            $client->contact_no    = $english['customer_contact_no'];
            $client->save();

            return Response::json(['success' => '1','message'=>'Seller Informaion Updated.']);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
    }
}
