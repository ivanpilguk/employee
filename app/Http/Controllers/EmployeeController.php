<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\EmployeeRepository;

use App\Employee;
use App\Post;

class EmployeeController extends Controller
{
    /**
     * The employee repository instance.
     *
     * @var EmployeeRepository
     */
    protected $employee;

    /**
     * Validation rules.
     *
     * @var string[]
     */
    protected $rules = [
            'surname' => 'required|max:100',
            'name' => 'required|max:100',
            'middlename' => 'required|max:100',
            'work_from' => 'required|date:Y-m-d',
            'salary' => 'required|numeric',
            'post_id' => 'numeric',
            'boss_id' => 'numeric',
        ];

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
        return view('employee.create',['posts'=>Post::get()]);
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

        return view('employee.edit', ['employee'=>$employee,'posts'=>Post::get()]);
    }

    /**
     * Create a new employee.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        //create new employee
        $employee=Employee::create([
            'surname' => $request->surname,
            'name' => $request->name,
            'middlename' => $request->middlename,
            'work_from' => $request->work_from,
            'salary' => $request->salary,
        ]);

        //set post for the employee
        if($request->post_id)
        {
            $post=Post::find($request->post_id);
            if($post)
            {
                $employee->post()->associate($post);
                $employee->save();
            }
        }

        //set boss for the employee
        if($request->boss_id)
        {
            $boss=Employee::find($request->boss_id);
            if($boss)
            {
                $employee->boss()->associate($boss);
                $employee->save();
            }
        }

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
        $this->validate($request, $this->rules);

        //update the employee information
        $employee->update([
            'surname' => $request->surname,
            'name' => $request->name,
            'middlename' => $request->middlename,
            'work_from' => $request->work_from,
            'salary' => $request->salary,
        ]);

        //set post for the employee
        if($request->post_id!=$employee->post_id)
        {
            if($request->post_id)
            {
                $post=Post::find($request->post_id);
                if($post)
                {
                    $employee->post()->associate($post);
                    $employee->save();
                }
            }
            else
            {
                $employee->post()->dissociate();
                $employee->save();
            }
        }

        //set boss for the employee
        if($request->boss_id!=$employee->boss_id)
        {
            if($request->boss_id)
            {
                $boss=Employee::find($request->boss_id);
                if($boss)
                {
                    $employee->boss()->associate($boss);
                    $employee->save();
                }
            }
            else
            {
                $employee->boss()->dissociate();
                $employee->save();
            }
        }

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
        $boss=$employee->boss;
        if($boss)
        {
            //set new boss for the subordinates before deleting
            foreach($employee->subordinates as $sub)
            {
                $sub->boss()->associate($boss);
                $sub->save();
            }
        }
        $employee->delete();

        return redirect('/list');
    }
}
