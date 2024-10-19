<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'active' => 'Student',
            'subActive' => 'Student_list',
        ];
        return view('frontend.student.student_list', $data);
    }

    public function fetchStudentList(Request $request)
    {
        $student = new Student();
        $collection = $student->fetchList($request);
        $count = $collection->count();
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayStart = intval($_REQUEST['start']);

        $output = array();
        $output['data'] = array();

        $numRow = $count;
        $iTotalRecords = (int)$numRow;
        $iDisplayLength = intval($_REQUEST['length']);
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($_REQUEST['start']);
        $sEcho = intval($_REQUEST['draw']);
        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $srNo = $iDisplayStart;
        $records = $collection->splice($iDisplayStart, $iDisplayLength);

        foreach ($records as $tRow) {
            $action = '';
            $action .= '<a href="update_student/' . base64_encode($tRow['id']) . ' "class="edit" id="' . base64_encode($tRow['id']) . '"title="Edit" route="student_form">' . edit_icon() . '</a>';
            $action .= ' <a href="javascript:void(0)" class="delete_record" id="' . base64_encode($tRow['id']) . '"title="Delete" table_id="student_table" route="delete_student">' . delete_icon() . '</a>';

            $output['data'][] = array(
                $tRow['id'],
                $tRow['student_name'],
                isset($tRow->teacher) ? $tRow->teacher->teacher_name : '-',
                $tRow['class'],
                Carbon::parse($tRow['admission_date'])->format('d F Y'),
                number_format($tRow['yearly_fees'], 2),
                $action
            );

            if ($srNo < $end) $srNo++;
        }

        $output["draw"] = $sEcho;
        $output["recordsTotal"] = $iTotalRecords;
        $output["recordsFiltered"] = $iTotalRecords;
        echo json_encode($output);
    }

    public function manageStudent(Request $request)
    {
        $student = new Student();
        $id = base64_decode($request->id);
        if ($id == -1) {
            $data = [
                'id' => $id,
                'pageTitle' => 'Add Student',
                'active' => 'student',
                'subActive' => 'student_list',
            ];
        } else {
            $edit = $student->edit($id);
            $data = [
                'id' => $id,
                'edit' => $edit,
                'pageTitle' => 'Edit Student',
                'active' => 'student',
                'subActive' => 'student_list',

            ];
        }

        $data['teachers'] = Teacher::get()->toArray();

        return view('frontend.student.student_form', $data);
    }

    public function addUpdate(Request $request)
    {
        $Student = new Student();
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string',
            'class_teacher_id' => 'required|integer',
            'class' => 'required|string',
            'admission_date' => 'required|date_format:d/m/Y',
            'yearly_fees' => 'required|numeric',
        ], [
            'class_teacher_id.required' => 'The Teacher field is required',
        ]);

        if ($validator->passes()) {
            if ($request->id != -1) {
                $id = $request->id;
            } else {
                $id = null;
            }

            $Student->student_name = $request->student_name ?? '';
            $Student->class_teacher_id = $request->class_teacher_id;
            $Student->class = $request->class;
            $Student->admission_date = Carbon::createFromFormat('d/m/Y', $request->admission_date)->format('Y-m-d');
            $Student->yearly_fees = $request->yearly_fees;

            $StudentVals = [
                'student_name' => $Student->student_name,
                'class_teacher_id' => $Student->class_teacher_id,
                'class' => $Student->class,
                'admission_date' => $Student->admission_date,
                'yearly_fees' => $Student->yearly_fees
            ];

            DB::transaction(function () use ($Student, $StudentVals, $id, $request) {
                $Student->updateOrInsert(['id' => $id], $StudentVals);
            });

            if ($request->id == -1) {
                $response['success'] = 1;
                $response['msg'] = 'Student Created Successfully';
            } else {
                $response['msg'] = 'Student Updated Successfully';
            }

            $response['redirect_url'] = url('/');
            return response()->json($response);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    public function deleteStudent($id)
    {
        $id = base64_decode($id);
        $res = Student::destroy($id);
        return $res;
    }
}
