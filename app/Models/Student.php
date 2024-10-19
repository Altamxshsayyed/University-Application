<?php

namespace App\Models;

use App\Models\Student as studentlModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;
    protected $hidden = ['updated_at', 'deleted_at'];
    protected $fillable = [
        'student_name',
        'class_teacher_id',
        'class',
        'admission_date',
        'yearly_fees',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'class_teacher_id');
    }

    public function edit($id = '')
    {
        $edit = studentlModel::where('id', $id)->first();
        return $edit;
    }

    public function fetchList($request)
    {
        $tFilter = ['student_name', 'class', 'yearly_fees'];
        $query = studentlModel::with('teacher');
        $query->select('students.*');
        foreach ($tFilter as $filter) {
            if (!empty($request['form'][$filter])) {
                $query->where($filter, 'like', "%{$request['form'][$filter]}%");
            }

            if (!empty($request['form']['teacher_name'])) {
                $query->whereHas('teacher', function ($q) use ($request) {
                    $q->where('teacher_name', 'like', "%{$request['form']['teacher_name']}%");
                });
            }
        }

        return $query->get();
    }
}
