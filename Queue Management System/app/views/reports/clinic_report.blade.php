@extends('layout/main')

@section('title')
    - Clinic Report
@stop

@section('header')
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/loading_mask/waitMe.css')}}">
@stop

@section('footer')
    <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/loading_mask/waitMe.js')}}"></script>
    <script>
        $(function () {

            //Datepicker
            $('.datepicker2').datepicker({
                todayHighlight: true,
                autoclose: true
            });

            $("#selectHospital2").change(function (e) {
                $("#selectClinic2").attr('disabled', 'disabled');
                $.ajax({
                    url: '{{route('getClinicsByHospitalId')}}',
                    method: 'POST',
                    data: {
                        hospital_id: $(this).val()
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#selectClinic2").removeAttr('disabled').html(data).select2();
                    }
                });
            });

            function getReport() {
                $("#download_excel_div").hide();
                withMe('#withMe');
                $.ajax({
                    url: '{{route('postClinicReports')}}',
                    method: 'POST',
                    data: {
                        hospital_id: $('#selectHospital2').val(),
                        clinic_id: $('#selectClinic2').val(),
                        from_date: $('#from_date').val(),
                        to_date: $('#to_date').val()
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $('#withMe').waitMe('hide');
                        if (data.response == 'false') {
                            alert(data.message);
                            $("#report_html").html('');
                            $("#download_excel_div").hide();
                        } else {
                            $("#download_excel_div").show();
                            window.history.pushState('', '', '?' + $("#getClinicReportForm").serialize());
                            $("#report_html").html(data.html);
                        }
                    }
                });
            }

            $("#getReport").click(function (e) {
                e.preventDefault();
                getReport();
            });

            $("#download_excel").click(function (e) {
                window.location.href = '{{route('excelClinicReport')}}?' + $("#getClinicReportForm").serialize();
            });

            @if(Input::get('hospital_id'))
            $.ajax({
                        url: '{{route('getClinicsByHospitalId')}}',
                        method: 'POST',
                        async: false,
                        data: {
                            hospital_id: '{{Input::get('hospital_id')}}'
                        },
                        headers: {token: '{{csrf_token()}}'},
                        success: function (data) {
                            $("#selectClinic2").html(data).select2();
                            @if(Input::get('clinic_id'))
                            $("#selectClinic2").val('{{Input::get('clinic_id')}}').select2();
                            @endif

                        }
                    });
            getReport();
            @endif

        });
    </script>
@stop

@section('content')
    <section class="content-header">
        <h1>
            Clinic Report
        </h1>
    </section>
    <section class="content">
        <div class="row" id="withMe">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- form start -->
                    <div class="box-header">
                        Criteria
                        <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                    {{Form::open(array('id' => 'getClinicReportForm'))}}
                    <div class="box-body">
                        <div class="form-group col-md-4">
                            <label>Hospital *</label>
                            <select required autocomplete="off" id="selectHospital2" name="hospital_id"
                                    class="form-control select2">
                                <option value="">Choose</option>
                                @foreach($hospitals as $val)
                                    <option value="{{$val['id']}}" @if(Input::get('hospital_id') == $val['id'])
                                    selected @endif>{{$val['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>Clinic</label>
                            <br>
                            <select autocomplete="off" id="selectClinic2" name="clinic_id"
                                    class="form-control select2">
                                <option value="">Choose</option>
                            </select>
                        </div>

                        <div class="form-group col-md-4">
                            <label>From Date *</label>
                            <input required id="from_date" type="text" data-date-format="yyyy-mm-dd"
                                   value="{{Input::get('from_date') ? Input::get('from_date') : date('Y-m-d')}}"
                                   name="from_date" class="form-control datepicker2">
                        </div>

                        <div class="form-group col-md-4">
                            <label>To Date *</label>
                            <input required id="to_date" type="text" data-date-format="yyyy-mm-dd"
                                   value="{{Input::get('to_date') ? Input::get('to_date') : date('Y-m-d')}}"
                                   name="to_date" class="form-control datepicker2">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button class="btn btn-primary" id="getReport">Get</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
            @if($c_user->user_type_id == 1 || $c_user->hasAccess('reports.clinic_report_excel'))
                <div class="col-md-12" id="download_excel_div" style="display: none;margin-bottom: 20px;">
                    <button id="download_excel" class="btn btn-primary">Download Excel</button>
                </div>
            @endif
            <div class="col-md-12">
                <div id="report_html">

                </div>
            </div>
        </div>
    </section>
@stop