@extends('frontend.layouts.app')
@section('onPageCss')
<!-- DataTables -->
<style>
    table.dataTable tbody tr.selected {
        background-color: transparent !important;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{url('public/frontend/plugins/datatable/css/dataTables.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/frontend/plugins/datatable/css/responsive.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/frontend/plugins/datatable/css/buttons.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/frontend/plugins/datatable/css/rowGroup.bootstrap5.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/frontend/plugins/datatable/css/rowReorder.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('public/frontend/plugins/datatable/css/editor.dataTables.min.css')}}">

@endsection
@section('content')
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y" style="padding: 2rem">
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h4 class="mb-0"><span class="text-muted fw-light">Student /</span> Student List</h4>
        <a id={{base64_encode('-1')}} href="add_student/{{base64_encode('-1')}}" class="btn btn-primary">Add Student</a>
    </div>
    <div class="">
        <!-- Category List Table -->
        <div class="ajax-msg mt-1 mb-1"></div>
        <div class="card mb-3">
            <div class="card-header border-bottom">
                <div class="alert alert-success d-flex align-items-center table-msg-alert d-none" id="table-msg" role="alert">
                    <span class="alert-icon text-success me-2">
                        <i class="ti ti-check ti-xs"></i>
                    </span>
                    <p class="alert-heading" id="table-msg-content"></p>
                </div>
                <h5 class="card-title mb-3">Search Filter</h5>
                <form name="filterData" id="filterData" method="POST">
                    <div class="row">
                        <div class="col-lg-3">
                            <label for="name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" name="student_name" id="student_name" value="" />
                        </div>
                        <div class="col-lg-3">
                            <label for="name" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" name="teacher_name" id="teacher_name" value="" />
                        </div>
                        <div class="col-lg-3">
                            <label for="title" class="form-label">Class</label>
                            <input type="text" class="form-control" name="class" id="class" value="" />
                        </div>
                        <div class="col-lg-3">
                            <label for="title" class="form-label">Yearly Fees</label>
                            <input type="number" class="form-control" name="yearly_fees" id="yearly_fees" value="" />
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary mt-4 submit_filter">Search</button>
                            <a class="btn btn-warning mt-4 reset_filter" href="{{url('/')}}">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="student_table" class="table responsive dataTable table-sm" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name</th>
                            <th>Teacher Name</th>
                            <th>Class</th>
                            <th>Admission Date</th>
                            <th>Yearly Fees</th>
                            <th class="noExport">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
@section('javascript')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{url('public/frontend/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{url('public/frontend/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
<script src="{{url('public/frontend/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('public/frontend/plugins/datatable/js/dataTables.rowReorder.min.js')}}"></script>
<script src="{{url('public/frontend/plugins/datatable/js/dataTables.editor.min.js')}}"></script>
<script src="{{url('public/frontend/custom/student/student_list.js?v=0.11')}}"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Student.handleList();
    });
</script>
@endsection