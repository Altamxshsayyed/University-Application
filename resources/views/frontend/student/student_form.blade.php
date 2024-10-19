@extends('frontend.layouts.app')
@section('onPageCss')
<style>
    .bootstrap-select .dropdown-toggle {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        box-shadow: none !important;
        padding: 0.375rem 0.75rem !important;
    }

    .bootstrap-select .dropdown-menu {
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
    }

    .sidebar {
        list-style-type: none;
        padding: 0;
    }

    .sidebar-item {
        margin: 10px 0;
    }

    .sidebar-link {
        text-decoration: none;
        color: black;
        padding: 10px;
        display: block;
    }

    .sidebar-item.active .sidebar-link {
        background-color: #007bff;
        color: white;
    }
</style>
@endSection
@php

$teachers = isset($teachers) ? $teachers : [];
if(isset($edit) && !empty($edit)){
$studentName = $edit['student_name'];
$teacherId = $edit['class_teacher_id'];
$class = $edit['class'];
$admissionDate = $edit['admission_date'] ? \Carbon\Carbon::parse($edit['admission_date'])->format('d/m/Y') : '';
$yearlyFees = $edit['yearly_fees'];
}else {
$studentName = '';
$teacherId = '';
$admissionDate = '';
$class = '';
$yearlyFees = '';
}
@endphp
@section('content')
<div class="container-xxl flex-grow-1 container-p-y" style="padding: 2rem">
    <div class="mb-4 d-flex align-items-center">
        <nav aria-label="breadcrumb" style="width: 100%;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{url('/')}}">Student</a>
                </li>
                <li class="breadcrumb-item active">
                    {{ $pageTitle }}
                </li>
            </ol>
        </nav>
    </div>
    <form class="form" id="ajax_form" method="POST" route="save_student">
        @csrf
        <div class="row">
            <div class="ajax-msg"></div>
            <div class="col-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-tile mb-0">Student</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3 ajax-field">
                                <input type="hidden" name="id" value="{{$id}}">
                                <label class="form-label" for="name">Student</label>
                                <input type="text" class="form-control" id="student" placeholder="Student Name" name="student_name" value="{{ $studentName }}">
                                <span id="student_name_err" class="error student_name_err small" style="color:red;"></span>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label" for="status">Teacher</label>
                                <select class="selectpicker w-100" name="class_teacher_id" data-style="btn-default">
                                    @if(isset($teachers) && !empty($teachers))
                                    <option selected value="">select</option>
                                    @foreach($teachers as $t)
                                    <option {{ $t['id'] == $teacherId ? 'selected' : '' }} value="{{$t['id']}}">{{$t['teacher_name']}}</option>
                                    @endforeach
                                </select>
                                @endif
                                <span id="class_teacher_id_err" class="error class_teacher_id_err small" style="color:red;"></span>
                            </div>
                            <div class="col-lg-6 mb-3 ajax-field">
                                <label class="form-label" for="class">Class</label>
                                <input type="text" class="form-control" id="class" placeholder="Class" name="class" value="{{ $class }}">
                                <span id="class_err" class="error class_err small" style="color:red;"></span>
                            </div>
                            <div class="col-lg-6 mb-3 ajax-field">
                                <label class="form-label" for="yearly_fees">Admission Date</label>
                                <input type="text" class="form-control datepicker" id="admission_date" placeholder="Admission date" name="admission_date" value="{{ $admissionDate }}">
                                <span id="admission_date_err" class="error admission_date_err small" style="color:red;"></span>
                            </div>
                            <div class="col-lg-6 mb-3 ajax-field">
                                <label class="form-label" for="yearly_fees">Yearly Fees</label>
                                <input type="number" class="form-control" id="yearly_fees" placeholder="Yearly Fees" name="yearly_fees" value="{{ $yearlyFees }}">
                                <span id="yearly_fees_err" class="error yearly_fees_err small" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success submit-button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</form>
</div>
@endsection
@section('javascript')
<script src="{{url('public/frontend/custom/student/student_form.js?v=0.11')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        StudentForm.handleFormValid();
    });
</script>
@endsection