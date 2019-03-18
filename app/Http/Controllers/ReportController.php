<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
use Auth;
use App\Client;
use App\Deposit;
use App\ExtraCost;
use App\Organization;
use App\SalesAndPurchase;
use App\Product;
use App\Salary;
use App\User;
use App\Libraries\Library;

class ReportController extends Controller
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
	public function balanceRecive(){
		return view('dashboard.customer_info.recivepayment');
	}
    public function getChangeClicnt(Request $request){
    	$data = Client::orderBy('org_name','asc')->where('user_id','=',Auth::user()->author_id)->where('typeOfClient','=',$request->id)->get();
    	return Response()->json($data);
    }
    public function getClientTotalAmount(Request $request){
        $buyeramount = DB::table('sales_and_purchases')->where('sales_and_purchases.client_id','=',$request->id)
                    ->leftjoin('deposits','deposits.client_id','=','sales_and_purchases.client_id')
                    ->select('sales_and_purchases.client_id','deposits.client_id',DB::raw('SUM(sales_and_purchases.total_amount) as total_purchase_amount'),DB::raw('SUM(deposits.deposit_amount) as total_deposit_amount'))
                    ->groupBy('sales_and_purchases.client_id')
                    ->groupBy('deposits.client_id')
                    ->get();
        return Response()->json($buyeramount);
    }
    public function recivepaymentstore(Request $request){
    	$validator = Validator::make($request->all(),[
            'owner_id' => 'required',
            'customer_name' => 'required',
            'recive_amount' => 'required',
        ]);
        if ($validator->passes()) {
            $bangla = array(
                    'recive_amount' => $request->recive_amount,
                );
            $english = Library::bn2en($bangla);
            $data = new Deposit;
            $data->user_id      = Auth::user()->author_id;
            $data->posting_author_id      = Auth::user()->id;
            $data->client_id      = $request->customer_name;
            $data->date         = $request->date;
            $data->deposit_amount    = $english['recive_amount'];
            $data->typeOfClient  = $request->owner_id;
            $data->save();

            return Response::json(['success' => '1','userid'=> $data->id]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
    }
    public function invoiceWiseBoucher(){
    	return view('dashboard.reports.invoiceWiseBoucher');
    }
    public function getInvoiceNumber(Request $request){
    	$data = DB::table('products')
    				->where('products.user_id','=',Auth::user()->author_id)
    				->where('products.client_id','=',$request->id)
    				->leftjoin('invoices','invoices.id','=','products.invoice_id')
    				->orderBy('invoices.invoice_no','asc')
    				->select('invoices.*')->distinct()->get();
    	return Response()->json($data);
    }
    public function boucherPageFind(Request $request){
    	$validator = Validator::make($request->all(),[
            'owner_id' => 'required',
            'customer_name' => 'required',
            'invoice_no' => 'required',
        ]);
        if ($validator->passes()) {

           $encode_id = base64_encode($request->invoice_no);
            $encode_client_id = base64_encode($request->customer_name);

            return Response()->json(['success'=>'1','invoice_id'=>$encode_id,'client_id'=>$encode_client_id,'owner'=>$request->owner_id]);
        }
        else
        {
            return Response::json(['errors' => $validator->errors()]);      
        }
    }
    public function findBoucherCustomer($cid,$id){
    	$client_id = base64_decode($cid); 
        $invoice_id = base64_decode($id);
        $extraCost = ExtraCost::where('user_id','=',Auth::user()->author_id)->where('client_id','=',$client_id)->where('invoice_id','=',$invoice_id)->get();
        $proData = DB::table('products')
                ->where('products.user_id','=',Auth::user()->author_id)
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
    public function findBoucherSeller($cid,$id){
    	$client_id = base64_decode($cid); 
        $invoice_id = base64_decode($id);
        $extraCost = ExtraCost::where('user_id','=',Auth::user()->author_id)->where('client_id','=',$client_id)->where('invoice_id','=',$invoice_id)->get();
        $proData = DB::table('products')
                ->where('products.user_id','=',Auth::user()->author_id)
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
        return view('dashboard.seller_info.voucher',compact('proData','extraCost','org'));
    }

    public function customerWiseReport(){
        $allCusomer = DB::table('sales_and_purchases')
                        ->where('sales_and_purchases.user_id','=',Auth::user()->author_id)
                        ->where('sales_and_purchases.typeOfClient','=','Customer')
                        ->leftjoin('clients','clients.id','=','sales_and_purchases.client_id')
                        ->leftjoin('extra_costs','extra_costs.invoice_id','=','sales_and_purchases.invoice_id')
                        ->leftjoin('invoices','invoices.id','=','sales_and_purchases.invoice_id')
                        ->select('sales_and_purchases.total_amount','sales_and_purchases.date','clients.org_name','clients.address','extra_costs.invoice_id','invoices.invoice_no',DB::raw('SUM(extra_costs.amount) as extra_cost'))
                        ->groupBy('extra_costs.invoice_id')
                        ->groupBy('sales_and_purchases.total_amount','sales_and_purchases.date')
                        ->groupBy('clients.org_name','clients.address')
                        ->groupBy('invoices.invoice_no')
                        ->get();
        
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.customerWiseReport',compact('allCusomer','org'));
    }
    public function sellerWiseReport(){
        $allCusomer = DB::table('sales_and_purchases')
                        ->where('sales_and_purchases.user_id','=',Auth::user()->author_id)
                        ->where('sales_and_purchases.typeOfClient','=','Seller')
                        ->leftjoin('clients','clients.id','=','sales_and_purchases.client_id')
                        ->leftjoin('extra_costs','extra_costs.invoice_id','=','sales_and_purchases.invoice_id')
                        ->leftjoin('invoices','invoices.id','=','sales_and_purchases.invoice_id')
                        ->select('sales_and_purchases.total_amount','sales_and_purchases.date','clients.org_name','clients.address','extra_costs.invoice_id','invoices.invoice_no',DB::raw('SUM(extra_costs.amount) as extra_cost'))
                        ->groupBy('extra_costs.invoice_id')
                        ->groupBy('sales_and_purchases.total_amount','sales_and_purchases.date')
                        ->groupBy('clients.org_name','clients.address')
                        ->groupBy('invoices.invoice_no')
                        ->get();
        
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.sellerWiseReport',compact('allCusomer','org'));
    }
    public function extraCoustReport(){
        $extraCost = DB::table('extra_costs')
                    ->where('extra_costs.user_id','=',Auth::user()->author_id)
                    ->where('extra_costs.owner_id','=','1')
                    ->get();
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.extraCostReport',compact('extraCost','org'));
    }
    public function clientWiseform(){
        return view('dashboard.reports.clientWiseReportForm');
    }
    public function clientsWiseReport(Request $request){
        $owner = $request->owner_id;
        $clientwise = DB::table('clients')
                        ->where('clients.user_id','=',Auth::user()->author_id)
                        ->where('clients.id','=',$request->customer_name)
                        ->leftjoin('sales_and_purchases','sales_and_purchases.client_id','=','clients.id')
                        ->select('clients.*','sales_and_purchases.*')->get();
        $extracost = ExtraCost::where('client_id','=',$request->customer_name)->where('user_id','=',Auth::user()->author_id)->get();
        $payment = Deposit::where('client_id','=',$request->customer_name)->where('user_id','=',Auth::user()->author_id)->get();
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.clientWiseReport',compact('clientwise','org','extracost','payment','owner'));
    }
    public function totalAcounts(){
        $auth_id = Auth::user()->author_id;
        $productCost = SalesAndPurchase::where('user_id','=',$auth_id)->get();

        $payment = Deposit::where('user_id','=',Auth::user()->author_id)->get();

        $extraCost = DB::Table('clients')->where('clients.user_id','=',$auth_id)
                    ->leftjoin('extra_costs','extra_costs.client_id','=','clients.id')
                    ->select('clients.*','extra_costs.amount')->get();
        
        $totalProCostCustomer = 0;
        $totalProCostSeller = 0;
        foreach ($productCost as $value) {
            if($value->typeOfClient == 'Customer'){
                $totalProCostCustomer += $value->total_amount;
            }elseif($value->typeOfClient == 'Seller'){
                $totalProCostSeller += $value->total_amount;
            }
        }

        $totalPaymentCustomer = 0;
        $totalPaymentSeller = 0;
        foreach ($payment as $value) {
            if($value->typeOfClient == 'Customer'){
                $totalPaymentCustomer += $value->deposit_amount;
            }elseif($value->typeOfClient == 'Seller'){
                $totalPaymentSeller += $value->deposit_amount;
            }
        }

        $totalExtraCostCustomer = 0;
        $totalExtraCostSeller = 0;
        foreach ($extraCost as $value) {
            if($value->typeOfClient == 'Customer'){
                $totalExtraCostCustomer += $value->amount;
            }elseif($value->typeOfClient == 'Seller'){
                $totalExtraCostSeller += $value->amount;
            }
        }

        $salary = Salary::where('user_id',$auth_id)->get();

        $totalSalaryCost = 0;
        foreach ($salary as $value) {
            $totalSalaryCost += $value->salary;
        }

        $ownerExtraCost = ExtraCost::where('owner_id','1')->get();
        $totalOwnerExtraCost = 0;
        foreach ($ownerExtraCost as $value) {
            $totalOwnerExtraCost += $value->amount;
        }
        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.totalBisnessAccount',compact('totalProCostCustomer','totalProCostSeller','totalPaymentCustomer','totalPaymentSeller','totalExtraCostCustomer','totalExtraCostSeller','org','totalSalaryCost','totalOwnerExtraCost'));
    }
    public function profiteForm(){
        return view('dashboard.reports.profiteform');
    }
    public function simpleprofite(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $product1 = SalesAndPurchase::where('user_id','=',Auth::user()->author_id)->whereBetween('date',array($request->start_date,$request->end_date))->get();
        $product = SalesAndPurchase::where('user_id','=',Auth::user()->author_id)->where('date','>=',$request->start_date)->where('date','<=',$request->end_date)->get();
        //return $product;
        $sellerPrice = 0;
        $customerPrice = 0;
        for($i=0; $i<count($product); $i++){
            if($product[$i]->typeOfClient == 'Seller'){
                $sellerPrice += $product[$i]->total_amount;
            }elseif($product[$i]->typeOfClient == 'Customer'){
                $customerPrice += $product[$i]->total_amount;
            }
        }

        $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.simpleProfite',compact('sellerDeposit','customerDeposit','customerextra','sellerextra','sellerPrice','customerPrice','org','start_date','end_date'));
    }
    public function profite(Request $request){
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $queryProduct = Product::where('user_id',Auth::user()->author_id)->where('date','>=',$request->start_date)->where('date','<=',$request->end_date)->get();
        $sellerPrice = 0;
        $customerPrice = 0;
        $seller_p_qty = 0;
        $customer_p_qty = 0;
        for($i=0; $i<count($queryProduct); $i++){
            if($queryProduct[$i]->typeOfProduct == 'Seller'){
                $sellerPrice += $queryProduct[$i]->amount;
                $seller_p_qty += $queryProduct[$i]->qty;
            }elseif($queryProduct[$i]->typeOfProduct == 'Customer'){
                $customerPrice += $queryProduct[$i]->amount;
                $customer_p_qty += $queryProduct[$i]->qty;
            }
        }
        $deposit = Deposit::where('user_id','=',Auth::user()->author_id)->where('date','>=',$request->start_date)->where('date','<=',$request->end_date)->get();

        $sellerDeposit = 0;
        $customerDeposit = 0;

        for($i=0; $i<count($deposit); $i++){
            if($deposit[$i]->typeOfClient == 'Seller'){
                $sellerDeposit += $deposit[$i]->deposit_amount;
            }elseif($deposit[$i]->typeOfClient == 'Customer'){
                $customerDeposit += $deposit[$i]->deposit_amount;
            }
        }

        $employerSalary = DB::table('salaries')->where('salaries.user_id','=',Auth::user()->author_id)
                    ->where('date','>=',$request->start_date)->where('date','<=',$request->end_date)
                    ->select(DB::raw('sum(salaries.salary) as total_salary'))->first();

        $extracost  = DB::table('sales_and_purchases')
                    ->where('sales_and_purchases.user_id','=',Auth::user()->author_id)
                    ->where('sales_and_purchases.date','>=',$request->start_date)->where('sales_and_purchases.date','<=',$request->end_date)
                    ->leftjoin('extra_costs','extra_costs.client_id','=','sales_and_purchases.client_id')
                    ->where('extra_costs.owner_id','=',1)
                    ->select('sales_and_purchases.typeOfClient','extra_costs.*')->get();
        $sellerextra = 0;
        $customerextra = 0;
        for($i=0; $i<count($extracost); $i++){
            if($extracost[$i]->typeOfClient == 'Seller'){
                $sellerextra += $extracost[$i]->amount;
            }elseif($extracost[$i]->typeOfClient == 'Customer'){
                $customerextra += $extracost[$i]->amount;
            }
        }
        if($seller_p_qty == 0){
            return redirect()->back()->with('message','No Data Found!!');
        }else{
            $avarage_rate = $sellerPrice/$seller_p_qty;
            $org = Organization::where('user_id','=',Auth::user()->author_id)->first();
        return view('dashboard.reports.profite',compact('sellerPrice','avarage_rate','customerPrice','customer_p_qty','org','start_date','end_date','sellerDeposit','customerDeposit','sellerextra','customerextra','employerSalary'));
        }
        
        
    }

    public function dateWiseForm(){
        return view('dashboard.reports.dateWiseForm');
    }

    public function dateWiseReport(Request $request){
        $roles = Auth::user()->roles[0]->slug;
        //return $roles;
        $user_id = Auth::user()->author_id;
        $auth_users = DB::table('users')->where('author_id',$user_id)
                ->leftjoin('role_users','role_users.user_id','=','users.id')
                ->leftjoin('roles','roles.id','=','role_users.role_id')->get();
        //return dd($auth_users);
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $users_array = array();
        foreach($auth_users as $value){
            if($roles == $value->slug){
              array_push($users_array,$value->user_id); 
            }
        }
        //return $users_array;
        if($roles == 'administrator'){
            $sales_purchase  = DB::table('sales_and_purchases')
                            ->where('sales_and_purchases.user_id','=',$user_id)
                            ->where('sales_and_purchases.date','>=',$request->start_date)->where('sales_and_purchases.date','<=',$request->end_date)
                            ->select('sales_and_purchases.typeOfClient','sales_and_purchases.date',DB::raw('sum(sales_and_purchases.total_amount) as total_amount'),DB::raw('sum(sales_and_purchases.recive_amount) as recive_amount'))
                            ->groupBy('sales_and_purchases.typeOfClient')
                            ->groupBy('sales_and_purchases.date')
                            ->get();
            $deposits  = DB::table('deposits')
                        ->where('deposits.user_id','=',$user_id)
                        ->where('deposits.date','>=',$request->start_date)->where('deposits.date','<=',$request->end_date)
                        ->select('deposits.typeOfClient','deposits.date',DB::raw('sum(deposits.deposit_amount) as total_deposit_amount'))
                        ->groupBy('deposits.typeOfClient')
                        ->groupBy('deposits.date')
                        ->get();
            $extra_costs  = DB::table('extra_costs')
                        ->where('extra_costs.user_id','=',$user_id)
                        ->where('extra_costs.owner_id','=',1)
                        ->where('extra_costs.date','>=',$request->start_date)->where('extra_costs.date','<=',$request->end_date)
                        ->select('extra_costs.date',DB::raw('sum(extra_costs.amount) as total_extra_amount'))
                        ->groupBy('extra_costs.date')
                        ->get(); 
        }else{
            $sales_purchase  = DB::table('sales_and_purchases')
                            ->whereIn('sales_and_purchases.posting_author_id',$users_array)
                            ->where('sales_and_purchases.date','>=',$request->start_date)->where('sales_and_purchases.date','<=',$request->end_date)
                            ->select('sales_and_purchases.typeOfClient','sales_and_purchases.date',DB::raw('sum(sales_and_purchases.total_amount) as total_amount'),DB::raw('sum(sales_and_purchases.recive_amount) as recive_amount'))
                            ->groupBy('sales_and_purchases.typeOfClient')
                            ->groupBy('sales_and_purchases.date')
                            ->get();
            $deposits  = DB::table('deposits')
                        ->whereIn('deposits.posting_author_id',$users_array)
                        ->where('deposits.date','>=',$request->start_date)->where('deposits.date','<=',$request->end_date)
                        ->select('deposits.typeOfClient','deposits.date',DB::raw('sum(deposits.deposit_amount) as total_deposit_amount'))
                        ->groupBy('deposits.typeOfClient')
                        ->groupBy('deposits.date')
                        ->get();
            $extra_costs  = DB::table('extra_costs')
                        ->whereIn('extra_costs.posting_author_id',$users_array)
                        ->where('extra_costs.owner_id','=',1)
                        ->where('extra_costs.date','>=',$request->start_date)->where('extra_costs.date','<=',$request->end_date)
                        ->select('extra_costs.date',DB::raw('sum(extra_costs.amount) as total_extra_amount'))
                        ->groupBy('extra_costs.date')
                        ->get();
        }
        $org = Organization::where('user_id','=',$user_id)->first();
         //return dd($sales_purchase);
        return view('dashboard.reports.dateWiseReport',compact('sales_purchase','deposits','extra_costs','org','start_date','end_date','auth_users','roles'));
    }

}
