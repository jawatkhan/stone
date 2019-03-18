<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use App\Color;
use App\Client;
use App\Product;
use App\TempProduct;
use Auth;
use App\Invoice;
use DB;
use App\Stock;
use App\ExtraCost;
use App\Organization;
use App\SalesAndPurchase;
use App\Deposit;
use App\Category;
use App\Libraries\Library;

class CustomerProductController extends Controller
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
    public function index($cid,$id){
        $client_id = base64_decode($cid); 
        $invoice_id = base64_decode($id);
        $articalno = Stock::orderBy('article_no','asc')->where('user_id','=',Auth::user()->author_id)->where('qty','>',0)->get();

        $tempProd = TempProduct::where('user_id','=',Auth::user()->author_id)->where('posting_author_id','=',Auth::user()->id)->where('client_id','=',$client_id)->where('invoice_id','=',$invoice_id)->get();
        $colors = Color::orderBy('color_name','asc')->pluck('color_name','id');
        $category = Category::where('parent_id','=',0)->latest()->get();
        return view('dashboard/customer_info/product',compact('colors','client_id','tempProd','invoice_id','category','articalno'));
    }
    public function articaleOnChange(Request $request){
        $article_no = $request->article_no;
        $data = Stock::where('stocks.article_no','=',$article_no)->where('user_id','=',Auth::user()->author_id)->first();
        return Response()->json($data);
    }
    public function inviceCreate(Request $request){
        $validator = Validator::make($request->all(),[
            'old_customer' => 'required',
        ]);
        if ($validator->passes()) {
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
            
            $encode_id = base64_encode($datas->id);
            $encode_client_id = base64_encode($request->old_customer);

            return Response::json(['success' => '1','client_id'=>$encode_client_id,'id'=>$encode_id]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
    }
    public function addProductInfos(Request $request){
        $validator = Validator::make($request->all(),[
            'article_no' => 'required|string',
            'color_id' => 'required',
            'qty' => 'required|regex:/^[১২৩৪৫৬৭৮৯০0-9]/',
            'p_rate' => 'required|regex:/^[১২৩৪৫৬৭৮৯০0-9]/',
            'date' => 'required|string',
        ]);

        if ($validator->passes()) {
            $bangla = array(
                    'qty' => $request->qty,
                    'p_rate' => $request->p_rate,
                );
            $english = Library::bn2en($bangla);
            $datas = new TempProduct;
            $datas->user_id = Auth::user()->author_id;
            $datas->posting_author_id = Auth::user()->id;
            $datas->client_id = $request->client_id;
            $datas->invoice_id = $request->invoice_id;
            $datas->article_no = $request->article_no;
            $datas->color_id = $request->color_id;
            $datas->qty  = $english['qty'];
            $datas->rate  = $english['p_rate'];
            $datas->amount  = $english['qty']*$english['p_rate'];
            $datas->date  = $request->date;
            $datas->save();

        $product = DB::table('temp_products')
                ->where('temp_products.user_id','=',Auth::user()->author_id)
                ->where('temp_products.client_id','=',$datas->client_id)
                ->where('temp_products.invoice_id','=',$datas->invoice_id)
                ->leftjoin('invoices','invoices.id','=','temp_products.invoice_id')
                ->leftjoin('categories','categories.id','=','temp_products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','temp_products.article_no')
                ->select('temp_products.*','invoices.invoice_no','categories.category_name','p_cats.category_name as cat_name')->get();
        $costDetail = DB::table('extra_costs')
                ->where('extra_costs.user_id','=',Auth::user()->author_id)
                ->where('extra_costs.client_id','=',$datas->client_id)
                ->where('extra_costs.invoice_id','=',$datas->invoice_id)
                ->leftjoin('invoices','invoices.id','=','extra_costs.invoice_id')
                ->select('extra_costs.*','invoices.invoice_no')->get();

            return Response::json(['success' => '1','prodArry'=>$product,'costArry'=>$costDetail]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
    }

    public function extraCostAdd(Request $request){
        $validator = Validator::make($request->all(),[
            'owner_id' => 'required',
            'description' => 'required|string',
            'extra_cost' => 'required|regex:/^[১২৩৪৫৬৭৮৯০0-9]/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'extra_cost' => $request->extra_cost,
                );
            $english = Library::bn2en($bangla);
            $data = new ExtraCost;
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->client_id = $request->client_id;
            $data->owner_id = $request->owner_id;
            $data->invoice_id = $request->invoice_id;
            $data->descriptions = $request->description;
            $data->amount = $english['extra_cost'];
            $data->date = date('Y-m-d');
            $data->save();

            $product = DB::table('temp_products')
                ->where('temp_products.user_id','=',Auth::user()->author_id)
                ->where('temp_products.client_id','=',$data->client_id)
                ->where('temp_products.invoice_id','=',$data->invoice_id)
                ->leftjoin('invoices','invoices.id','=','temp_products.invoice_id')
                ->leftjoin('categories','categories.id','=','temp_products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','temp_products.article_no')
                ->select('temp_products.*','invoices.invoice_no','categories.category_name','p_cats.category_name as cat_name')->get();

            $costDetail = DB::table('extra_costs')
                ->where('extra_costs.user_id','=',Auth::user()->author_id)
                ->where('extra_costs.client_id','=',$data->client_id)
                ->where('extra_costs.invoice_id','=',$data->invoice_id)
                ->leftjoin('invoices','invoices.id','=','extra_costs.invoice_id')
                ->select('extra_costs.*','invoices.invoice_no')->get();
            return Response::json(['success' => '1','prodArry'=>$product,'costArry'=>$costDetail]);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }
    public function productEdit(Request $request){
        $data = TempProduct::where('id','=',$request->id)->first();
        return Response::json($data);
    }

    public function editProductInfos(Request $request){
        $validator = Validator::make($request->all(),[
            'article_no' => 'required|string',
            'color_id' => 'required',
            'qty' => 'required',
            'p_rate' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'date' => 'required|string',
        ]);

        if ($validator->passes()) {
            $bangla = array(
                    'qty' => $request->qty,
                    'p_rate' => $request->p_rate,
                );
            $english = Library::bn2en($bangla);
        $datas = TempProduct::find($request->id);
        $datas->user_id = Auth::user()->author_id;
        $datas->posting_author_id = Auth::user()->id;
        $datas->client_id = $request->client_id;
        $datas->invoice_id = $request->invoice_id;
        $datas->article_no = $request->article_no;
        $datas->color_id = $request->color_id;
        $datas->qty  = $english['qty'];
        $datas->rate  = $english['p_rate'];
        $datas->amount  = $english['qty']*$english['p_rate'];
        $datas->date  = $request->date;
        $datas->save();

        $product = DB::table('temp_products')
                ->where('temp_products.user_id','=',Auth::user()->author_id)
                ->where('temp_products.posting_author_id','=',Auth::user()->id)
                ->where('temp_products.client_id','=',$datas->client_id)
                ->where('temp_products.invoice_id','=',$datas->invoice_id)
                ->leftjoin('invoices','invoices.id','=','temp_products.invoice_id')
                ->leftjoin('categories','categories.id','=','temp_products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','temp_products.article_no')
                ->select('temp_products.*','invoices.invoice_no','categories.category_name','p_cats.category_name as cat_name')->get();
        $costDetail = DB::table('extra_costs')
                ->where('extra_costs.user_id','=',Auth::user()->author_id)
                ->where('extra_costs.client_id','=',$datas->client_id)
                ->where('extra_costs.invoice_id','=',$datas->invoice_id)
                ->leftjoin('invoices','invoices.id','=','extra_costs.invoice_id')
                ->select('extra_costs.*','invoices.invoice_no')->get();

            return Response::json(['success' => '1','prodArry'=>$product,'costArry'=>$costDetail]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
    }
    public function deleteProduct(Request $request){
        $data = TempProduct::find($request->id);
        $data->delete();
        $product = DB::table('temp_products')
                ->where('temp_products.user_id','=',Auth::user()->author_id)
                ->where('temp_products.posting_author_id','=',Auth::user()->id)
                ->where('temp_products.client_id','=',$request->client_id)
                ->where('temp_products.invoice_id','=',$request->invoice_id)
                ->leftjoin('invoices','invoices.id','=','temp_products.invoice_id')
                ->leftjoin('categories','categories.id','=','temp_products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','temp_products.article_no')
                ->select('temp_products.*','invoices.invoice_no','categories.category_name','p_cats.category_name as cat_name')->get();
        $costDetail = DB::table('extra_costs')
                ->where('extra_costs.user_id','=',Auth::user()->author_id)
                ->where('extra_costs.client_id','=',$product[0]->client_id)
                ->where('extra_costs.invoice_id','=',$product[0]->invoice_id)
                ->leftjoin('invoices','invoices.id','=','extra_costs.invoice_id')
                ->select('extra_costs.*','invoices.invoice_no')->get();

            return Response::json(['success' => '1','prodArry'=>$product,'costArry'=>$costDetail]);
    }
    public function deleteExtraCost(Request $request){
        $data = ExtraCost::find($request->id);
        $data->delete();
        $product = DB::table('temp_products')
                ->where('temp_products.user_id','=',Auth::user()->author_id)
                ->where('temp_products.posting_author_id','=',Auth::user()->id)
                ->where('temp_products.client_id','=',$request->client_id)
                ->where('temp_products.invoice_id','=',$request->invoice_id)
                ->leftjoin('invoices','invoices.id','=','temp_products.invoice_id')
                ->leftjoin('categories','categories.id','=','temp_products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','temp_products.article_no')
                ->select('temp_products.*','invoices.invoice_no','categories.category_name','p_cats.category_name as cat_name')->get();
        $costDetail = DB::table('extra_costs')->where('extra_costs.user_id','=',Auth::user()->author_id)
                ->where('extra_costs.client_id','=',$product[0]->client_id)
                ->where('extra_costs.invoice_id','=',$product[0]->invoice_id)
                ->leftjoin('invoices','invoices.id','=','extra_costs.invoice_id')
                ->select('extra_costs.*','invoices.invoice_no')->get();

            return Response::json(['success' => '1','prodArry'=>$product,'costArry'=>$costDetail]);
    }
    public function editExtraCost(Request $request){
        $data = ExtraCost::where('user_id','=',Auth::user()->author_id)->where('id','=',$request->id)->first();
        return Response::json($data);
    }
    public function updateExtraCost(Request $request){
        $validator = Validator::make($request->all(),[
            'owner_id' => 'required',
            'description' => 'required|string',
            'extra_cost' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'extra_cost' => $request->extra_cost,
                );
            $english = Library::bn2en($bangla);
            $data = ExtraCost::find($request->id);
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->client_id = $request->client_id;
            $data->owner_id = $request->owner_id;
            $data->invoice_id = $request->invoice_id;
            $data->descriptions = $request->description;
            $data->amount = $english['extra_cost'];
            $data->date = date('Y-m-d');
            $data->save();

            $product = DB::table('temp_products')->where('temp_products.user_id','=',Auth::user()->author_id)
                ->where('temp_products.posting_author_id','=',Auth::user()->id)
                ->where('temp_products.client_id','=',$data->client_id)
                ->where('temp_products.invoice_id','=',$data->invoice_id)
                ->leftjoin('invoices','invoices.id','=','temp_products.invoice_id')
                ->leftjoin('categories','categories.id','=','temp_products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','temp_products.article_no')
                ->select('temp_products.*','invoices.invoice_no','categories.category_name','p_cats.category_name as cat_name')->get();

            $costDetail = DB::table('extra_costs')->where('extra_costs.user_id','=',Auth::user()->author_id)
                ->where('extra_costs.client_id','=',$data->client_id)
                ->where('extra_costs.invoice_id','=',$data->invoice_id)
                ->leftjoin('invoices','invoices.id','=','extra_costs.invoice_id')
                ->select('extra_costs.*','invoices.invoice_no')->get();
            return Response::json(['success' => '1','prodArry'=>$product,'costArry'=>$costDetail]);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }
    public function finalVoucherCreate(Request $request){
        $product = TempProduct::where('user_id','=',Auth::user()->author_id)->where('posting_author_id','=',Auth::user()->id)->where('client_id','=',$request->client_id)->where('invoice_id','=',$request->invoice_id)->get();
        $extraCost = ExtraCost::where('user_id','=',Auth::user()->author_id)->where('posting_author_id','=',Auth::user()->id)->where('client_id','=',$request->client_id)->where('invoice_id','=',$request->invoice_id)->get();
        $stock = Stock::where('user_id','=',Auth::user()->author_id)->get();
        
        DB::beginTransaction();
        if(count($product) >0 || count($extraCost) >0 ){
            $total_product_amount = 0;
            if(count($product)>0){

                for($i=0; $i<count($product); $i++){
                    $proInsert = new Product;
                    $proInsert->user_id = Auth::user()->author_id;
                    $proInsert->posting_author_id = Auth::user()->id;
                    $proInsert->client_id = $product[$i]->client_id;
                    $proInsert->invoice_id = $product[$i]->invoice_id;
                    $proInsert->article_no = $product[$i]->article_no;
                    $proInsert->color_id = $product[$i]->color_id;
                    $proInsert->qty  = $product[$i]->qty;
                    $proInsert->rate  = $product[$i]->rate;
                    $proInsert->amount  = $product[$i]->amount;
                    $proInsert->date  = $product[$i]->date;
                    $proInsert->typeOfProduct  = 'Customer';
                    $proInsert->save();

                    $total_product_amount += $product[$i]->amount;

                    if(count($stock) > 0){
                        for($j=0; $j < count($stock); $j++){
                            if($product[$i]->color_id == $stock[$j]->color_id){
                                $stk = Stock::find($stock[$j]->id);
                                $stk->qty = $stock[$j]->qty-$product[$i]->qty;
                                $stk->save();
                            }
                        }
                    }

                    $isStock = Stock::where('user_id','=',Auth::user()->author_id)->where('color_id','=',$product[$i]->color_id)->first();
                    if(empty($isStock)){
                        $stk = new Stock;
                        $stk->user_id = Auth::user()->author_id;
                        $stk->article_no = $product[$i]->article_no;
                        $stk->color_id = $product[$i]->color_id;
                        $stk->qty = $product[$i]->qty;
                        $stk->save();
                    }
                    
                    $data = TempProduct::find($product[$i]->id);
                    $data->delete();
                }
            }
            // --------sales and purchase-------
                    $bangla = array(
                            'recive_amount' => $request->recive_amount,
                        );
                    $english = Library::bn2en($bangla);
                    $saleAndPurchase = new SalesAndPurchase;
                    $saleAndPurchase->user_id = Auth::user()->author_id;
                    $saleAndPurchase->posting_author_id = Auth::user()->id;
                    $saleAndPurchase->client_id = $request->client_id;
                    $saleAndPurchase->invoice_id = $request->invoice_id;
                    $saleAndPurchase->total_amount = $total_product_amount;
                    $saleAndPurchase->recive_amount = $english['recive_amount']?$english['recive_amount']:0;
                    $saleAndPurchase->date = $product[0]->date;
                    $saleAndPurchase->typeOfClient = 'Customer';
                    $saleAndPurchase->save();

                    if($request->recive_amount != ''){
                        $bangla = array(
                            'recive_amount' => $request->recive_amount,
                        );
                    $english = Library::bn2en($bangla);
                        $deposit = new Deposit;
                        $deposit->user_id = Auth::user()->author_id;
                        $deposit->posting_author_id = Auth::user()->id;
                        $deposit->client_id = $request->client_id;
                        $deposit->invoice_id = $request->invoice_id;
                        $deposit->deposit_amount = $english['recive_amount'];
                        $deposit->date = $product[0]->date;
                        $deposit->typeOfClient = 'Customer';
                        $deposit->save();
                    }

            DB::commit();
            $encode_id = base64_encode($request->invoice_id);
            $encode_client_id = base64_encode($request->client_id);

            return Response()->json(['success'=>'1','invoice_id'=>$encode_id,'client_id'=>$encode_client_id,]);
            
        }else{
            return Response()->json(['message'=>'No Product found. Please Entry First.']);
        }
    }
    public function voucherPage($cid,$id){
        $client_id = base64_decode($cid); 
        $invoice_id = base64_decode($id);
        $extraCost = ExtraCost::where('user_id','=',Auth::user()->author_id)->where('posting_author_id','=',Auth::user()->id)->where('client_id','=',$client_id)->where('invoice_id','=',$invoice_id)->get();
        $proData = DB::table('products')
                ->where('products.user_id','=',Auth::user()->author_id)
                ->where('products.posting_author_id','=',Auth::user()->id)
                ->where('products.client_id','=',$client_id)
                ->where('products.invoice_id','=',$invoice_id)
                ->leftjoin('users','users.id','=','products.posting_author_id')
                ->leftjoin('clients','clients.id','=','products.client_id')
                ->leftjoin('invoices','invoices.id','=','products.invoice_id')
                ->leftjoin('deposits','deposits.invoice_id','=','products.invoice_id')
                ->leftjoin('categories','categories.id','=','products.color_id')
                ->leftjoin('categories as p_cats','p_cats.id','=','products.article_no')
                ->select('products.*','clients.org_name','clients.address','clients.contact_no','invoices.invoice_no','users.name','deposits.deposit_amount','categories.category_name','p_cats.category_name as cat_name')
                ->get();
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.customer_info.voucher',compact('proData','extraCost','org'));
    }

    public function getAmountSummary(){
        $salesPurch = DB::table('sales_and_purchases')
                ->where('sales_and_purchases.user_id','=',Auth::user()->author_id)
                ->where('sales_and_purchases.typeOfClient','=','Customer')
                ->join('clients','clients.id','=','sales_and_purchases.client_id')
                ->select('clients.org_name','sales_and_purchases.client_id', DB::raw('SUM(sales_and_purchases.total_amount) as total_sales'))
                ->groupBy('sales_and_purchases.client_id')
                ->groupBy('clients.org_name')
                ->get();
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.customer_info.arrears',compact('salesPurch','org'));
    }
}
