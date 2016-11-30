<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employee';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'middlename', 'work_from', 'salary',
    ];

    /**
     * Get the boss of the employee.
     */
    public function boss()
    {
        return $this->belongsTo(Employee::class, 'boss_id');
    }

    /**
     * Get the post of the employee.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the subordinates of the employee.
     */
    public function getSubList()
    {
        return $this->hasMany(Employee::class, 'boss_id');
    }
}
