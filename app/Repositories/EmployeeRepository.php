<?php

namespace App\Repositories;

use App\Employee;

class EmployeeRepository
{
    /**
     * Get list of the employee.
     *
     * @param array $params
     * @return Collection
     */
    public function getList($params=array())
    {
        $sort='id';
        $sort_type='asc';
        if(!empty($params["sort"]))
        {
            $s=explode(" ",$params["sort"]);
            if($s[0])
            {
                $sort=$s[0];
            }
            if($s[1])
            {
                $sort_type=$s[1];
            }
        }

        $search_field="id";
        $search_type="<>";
        $search_text="NULL";
        if(!empty($params["search_text"])&&!empty($params["search_field"]))
        {
            $text_fields=array("surname","name","middlename");
            $search_field=$params["search_field"];
            if(in_array($params["search_field"],$text_fields))
            {
                $search_type="LIKE";
                $search_text="%".$params["search_text"]."%";
            }
            else
            {
                $search_type="=";
                $search_text=$params["search_text"];
            }
        }
        
        return Employee::orderBy($sort, $sort_type)->where($search_field, $search_type, $search_text)->paginate(10);
    }

    /**
     * Get big boss id.
     *
     * @return int
     */
    public function getBigBossId()
    {
        return Employee::whereNull('boss_id')->first()->id;
    }

    /**
     * Get employee tree.
     *
     * @param  $employee_id
     * @return array
     */
    public function getTree($employee_id=null)
    {
        $params=array();
        //if employee_id is not null - get lazy tree, else - get full tree
        if($employee_id!==null)
        {
            $boss_id=array();
            $boss_id[]=$employee_id;
            if($employee_id!=0)
            {
                //get all parents boss_id
                $boss_id=$this->getParentsBossId($employee_id,$boss_id);
            }
            $params=$boss_id;
        }
        if(!empty($params))
        {
            $employees_all = Employee::whereIn('boss_id', $params)->orWhereNull('boss_id')->get();
        }
        else
        {
            $employees_all = Employee::get();
        }
        $employees=array();
        $employees_tmp=array();
        foreach($employees_all as $employee)
        {
            $tmp=new \stdClass();
            $tmp->id=$employee->id;
            $tmp->name=$employee->name;
            $tmp->surname=$employee->surname;
            $tmp->middlename=$employee->middlename;
            $tmp->boss_id=$employee->boss_id;
            $tmp->post_name=$employee->post->name;
            $employees_tmp[$employee->id]=$tmp;
        }
        $employees[0]=new \stdClass();
        $employees[0]->group=array();
        $finish = false;
        while(!empty($employees_tmp) && !$finish)
        {
            $flag = false;
            foreach($employees_tmp as $k=>$employee)
            {
                if(isset($employees[intval($employee->boss_id)]))
                {
                    $employees[$employee->id]=$employees[intval($employee->boss_id)]->group[$employee->id]=$employee;
                    unset($employees_tmp[$k]);
                    $flag = true;
                }
            }
            if(!$flag) $finish = true;
        }
        $result=$employees[0]->group;
        return $result;
    }

    /**
     * Get parents boss_id by the employee id.
     *
     * @param  $id
     * @param  &$boss_id
     * @return array
     */
    private function getParentsBossId($id,&$boss_id)
    {
        $employee = Employee::find($id);
        if(intval($employee->boss_id)!=0&&$employee->id!=$employee->boss_id)
        {
            $boss_id[]=$employee->boss_id;
            $this->getParentsBossId($employee->boss_id,$boss_id);
        }
        return $boss_id;
    }
}