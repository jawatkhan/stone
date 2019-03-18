<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Response;
use Auth;
use App\Employer;
use DB;
use App\Salary;
use App\Libraries\Library;

class EmployerController extends Controller
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
    public function index(){
    	$employer = Employer::orderBy('name','asc')->paginate(10);
    	return view('dashboard.employers.employer',compact('employer'));
    }

    public function insertEmployer(Request $request){
    	$validator = Validator::make($request->all(),[
            'employer_name' => 'required|string',
            'father_name' => 'required|string',
            'address' => 'required|string',
            'contact_no' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'designation' => 'required|string',
            'present_salary' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'contact_no' => $request->contact_no,
                    'present_salary' => $request->present_salary,
                );
            $english = Library::bn2en($bangla);
            $data = new Employer;
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->name = $request->employer_name;
            $data->father_name = $request->father_name;
            $data->address = $request->address;
            $data->contact_no = $english['contact_no'];
            $data->designation = $request->designation;
            $data->monthly_salary = $english['present_salary'];
            $data->save();
            return Response::json(['success' => '1']);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }

    public function editEmployer(Request $request){
    	$data = Employer::find($request->id);
    	return Response()->json($data);
    }

    public function updateEmployer(Request $request){
    	$validator = Validator::make($request->all(),[
            'employer_name' => 'required|string',
            'father_name' => 'required|string',
            'address' => 'required|string',
            'contact_no' => 'required|regex:/^\d*(\.\d{1,2})?$/',
            'designation' => 'required|string',
            'present_salary' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'contact_no' => $request->contact_no,
                    'present_salary' => $request->present_salary,
                );
            $english = Library::bn2en($bangla);
            $data = Employer::find($request->id);
            $data->name = $request->employer_name;
            $data->father_name = $request->father_name;
            $data->address = $request->address;
            $data->contact_no = $english['contact_no'];
            $data->designation = $request->designation;
            $data->monthly_salary = $english['present_salary'];
            $data->save();
            return Response::json(['success' => '1']);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }

    public function deleteEmployer($id){
    	$del = Employer::find($id);
    	$del->delete();
    	return back();
    }

    public function salaryPayment(){
    	$salary = DB::table('salaries')->orderBy('salaries.date','desc')->where('salaries.user_id','=',Auth::user()->author_id)
    			->leftjoin('employers','employers.id','=','salaries.employer_id')
    			->select('salaries.*','employers.name','employers.contact_no','employers.designation')
    			->get();
    	$employer = Employer::orderBy('name','asc')->get();
    	return view('dashboard.employers.employerSalary',compact('salary','employer'));
    }

    public function insertSalary(Request $request){
    	$validator = Validator::make($request->all(),[
            'employer_name' => 'required|string',
            'payment_date' => 'required|string',
            'present_salary' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'present_salary' => $request->present_salary,
                );
            $english = Library::bn2en($bangla);
            $data = new Salary;
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->employer_id = $request->employer_name;
            $data->salary = $english['present_salary'];
            $data->date = $request->payment_date;
            $data->save();
            return Response::json(['success' => '1']);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }

    public function editSalary(Request $request){
    	$data = Salary::find($request->id);
    	return Response()->json($data);
    }

    public function updateSalary(Request $request){
    	$validator = Validator::make($request->all(),[
            'employer_name' => 'required|string',
            'payment_date' => 'required|string',
            'present_salary' => 'required|regex:/^\d*(\.\d{1,2})?$/',
        ]);
        if($validator->passes()){
            $bangla = array(
                    'present_salary' => $request->present_salary,
                );
            $english = Library::bn2en($bangla);
            $data = Salary::find($request->id);
            $data->user_id = Auth::user()->author_id;
            $data->posting_author_id = Auth::user()->id;
            $data->employer_id = $request->employer_name;
            $data->salary = $english['present_salary'];
            $data->date = $request->payment_date;
            $data->save();
            return Response::json(['success' => '1']);
        }else{
            return Response::json(['errors'=>$validator->errors()]);
        }
    }

    public function deleteSalary($id){
    	$del = Salary::find($id);
    	$del->delete();
    	return back();
    }
}
