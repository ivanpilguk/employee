<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\EmployeeRepository;

class EmployeeController extends Controller
{
    /**
     * The employee repository instance.
     *
     * @var EmployeeRepository
     */
    protected $employee;

    /**
     * Create a new controller instance.
     *
     * @param  EmployeeRepository  $tasks
     * @return void
     */
    public function __construct(EmployeeRepository $employee)
    {
        $this->middleware('auth')->except(['index', 'lazy_tree']);

        $this->employee = $employee;
    }

    /**
     * Display a tree of all of the employee.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('employee.index', [
            'employee' => $this->employee->getTree($this->employee->getBigBossId()),
        ]);
    }

    /**
     * Display a tree of all of the employee.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function lazy_tree(Request $request, $id)
    {
        return view('employee.index', [
            'employee' => $this->employee->getTree(intval($id)),
        ]);
    }

    /**
     * Display a list of all of the employee.
     *
     * @param  Request  $request
     * @return Response
     */
    public function grid(Request $request)
    {
    	//get sort from url query or session
    	$sort="";
    	$session_sort = $request->session()->get('sort', 'id');
    	$sort_type = $request->session()->get('sort_type', 'asc');
    	$request_sort = $request->input('sort');
    	if($request_sort)
    	{
	    	if($session_sort==$request_sort)
	    	{
	    		if($sort_type=="asc")
	    		{
	    			$sort_type="desc";
	    		}
	    		else
	    		{
	    			$sort_type="asc";
	    		}
	    	}
	    	else
	    	{
	    		$sort_type="asc";
	    		$request->session()->put('sort', $request_sort);
	    	}
	    	$request->session()->put('sort_type', $sort_type);

			return redirect()->action(
				'EmployeeController@grid', $request->except("sort")
			);
    	}
    	$sort=$session_sort." ".$sort_type;

    	//get search parameters
    	$search_text=$request->input("query");
    	$search_field=$request->input("search_field");

        return view('employee.grid', [
            'employee' => $this->employee->getList(["sort"=>$sort,"search_text"=>$search_text,"search_field"=>$search_field]),
        ]);
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Show the form for editing the employee.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $employee=Employee::find($id);
        if(is_null($employee))
        {
            return redirect("/list");
        }

        return view('employee.edit', ['employee'=>$employee]);
    }

    /**
     * Create a new employee.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            //
        ]);

        $request->employee()->create([
            'name' => $request->name,
            //
        ]);

        return redirect('/list');
    }

    /**
     * Update the given employee.
     *
     * @param  Request  $request
     * @param  Employee  $employee
     * @return Response
     */
    public function update(Request $request, Employee $employee)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            //
        ]);

        $employee->update([
            'name' => $request->name,
            //
        ]);

        return redirect('/list');
    }

    /**
     * Destroy the given employee.
     *
     * @param  Request  $request
     * @param  Employee  $employee
     * @return Response
     */
    public function destroy(Request $request, Employee $employee)
    {
        $employee->delete();

        return redirect('/list');
    }
}
