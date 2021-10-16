<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Auth;
use Redirect;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $employees = Employee::with(['user'])
                             ->get();

        return view('home', compact('employees'));
    }

    public function create()
    {
        // dd();
        return view('create');
        // return redirect()->route('create', app()->getLocale());
        // return redirect()->route('create', app()->getLocale());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'               => 'required|max:256',
            'contact'            => 'required|max:256|unique:employees',
            'email'              => 'required|max:256|email|unique:employees',
            'date_of_birth'      => 'required',      
            'picture'            => 'required|max:1000|mimes:jpg,jpeg,png',
        ]);

  
        $employee                           = new Employee;
        $employee->name                     = $request->name;
        $employee->contact                  = $request->contact;
        $employee->email                    = $request->email;
        $employee->date_of_birth            = $request->date_of_birth;

        if($request->hasfile('picture'))
        {  
            $picture                = $request->file('picture');
            $temp_picture           = time() . '.' . $picture->getClientOriginalExtension();
            $path                   = $request->file('picture')->storeAs('uploads',$temp_picture, 'public');
            $employee->picture_path = '/storage/'.$path;
            $employee->picture      = $picture->getClientOriginalName();
        } 

        $employee->user_id = Auth::user()->id;
        
        $employee->save();
        

        if($employee)
        {
            Session::flash('message', 'Employee Create succesfully!');
            Session::flash('alert-status', 'success');
            return redirect()->route('home', app()->getLocale()); 
        }
        else{
              Session::flash('message', 'Something went wrong!');
              Session::flash('alert-status', 'danger');
              return redirect()->route('home', app()->getLocale());
        }
    }



    public function edit($language, $id)
    {
        // $user = User::get();
        $employee = Employee::where('id',$id)->first();

        return view('edit',compact('employee'));
        // return Redirect::route('edit', [$id, app()->getLocale()])->with( ['employee' => $employee] );

    }

    public function update(Request $request, $id, $language )
    {
        // dd($id);
        $validated = $request->validate([
            'name'               => 'required|max:256',
            'contact'            => 'required|max:256|unique:employees,contact,'.$id.',id',
            'email'              => 'required|max:256|email|unique:employees,email,'.$id.',id',
            'date_of_birth'      => 'required'
        ]);

  
        $employee                           = Employee::find($id);
        $employee->name                     = $request->name;
        $employee->contact                  = $request->contact;
        $employee->email                    = $request->email;
        $employee->date_of_birth            = $request->date_of_birth;

        if($request->hasfile('picture'))
        {  
            $validated = $request->validate([     
                'picture'            => 'required|max:1000|mimes:jpg,jpeg,png'
            ]);

            $picture                = $request->file('picture');
            $temp_picture           = time() . '.' . $picture->getClientOriginalExtension();
            $path                   = $request->file('picture')->storeAs('uploads',$temp_picture, 'public');
            $employee->picture_path = '/storage/'.$path;
            $employee->picture      = $picture->getClientOriginalName();
        } 

        $employee->user_id = Auth::user()->id;
        
        $employee->save();
        

        if($employee)
        {
            // dd(app()->getLocale());
            Session::flash('message', 'Employee Create succesfully!');
            Session::flash('alert-status', 'success');
            return redirect()->route('home', app()->getLocale());
        }
        else{
              Session::flash('message', 'Something went wrong!');
              Session::flash('alert-status', 'danger');
              return redirect()->route('home', app()->getLocale());
        }
    }

    public function delete($id)
    {
        // $employee = Employee::where('id',$id)->first();
        // $image=$employee->picture_path;

        // return response()->json($employee->picture_path);
        $check_path = Employee::where('id',$id)->first();

        $full_path = public_path().'/'.$check_path->picture_path;

        unlink($full_path);

        $delete = Employee::where('id',$id)->delete();
        if ($delete) {
            
            $notification=array(
                'messege'=>'Deleted succesfully',
                'alert-type'=>'success'
                );
            return redirect()->route('home', app()->getLocale())->with($notification);
        }else{
            $notification=array(
                'messege'=>'Something went wrong',
                'alert-type'=>'error'
                );
            return redirect()->route('home', app()->getLocale())->with($notification);
        }
    }
}
