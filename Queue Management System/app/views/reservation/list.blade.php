@extends('layout/main')

@section('title')
    - Reservations
@stop


@section('header')
    <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables/dataTables.bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/autocomplete/jquery.autocomplete.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datetimepicker/jquery.datetimepicker.css')}}">

@stop

@section('footer')
    <script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/autocomplete/jquery.autocomplete.js')}}"></script>
    <script src="{{asset('plugins/datetimepicker/jquery.datetimepicker.full.js')}}"></script>

    {{--    <script src="{{asset('plugins/responsivevoice/responsivevoice.js')}}"></script>--}}
    <script>
        $(document).ready(function () {
            $('.timepicker').datetimepicker({
                datepicker: false,
                format: 'H:i',
                step: 5
            });

            @if($c_user->user_type_id == \core\enums\UserRules::patientRelation)
            $('#example1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
//                        "order": [[4, "desc"], [5, 'asc']],
                "sScrollY": "400px",
                "sScrollX": "100%",
//                "sScrollXInner": "250%",
                "bScrollCollapse": true
            });
            @else
            $('#example1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": true,
//                        "order": [[4, "desc"], [5, 'asc']],
                "sScrollY": "400px",
                "sScrollX": "100%",
                "sScrollXInner": "250%",
                "bScrollCollapse": true
            });

            @endif

            function dataTableExample2() {
                $('#example2').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
//                    "order": [[4, "desc"], [5, 'asc']],
                    "sScrollY": "400",
                    "sScrollX": "100%",
                    "sScrollXInner": "250%",
                    "bScrollCollapse": true
                });
            }

            function dataTableExample3() {
                $('#example3').DataTable({
                    "paging": false,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": false,
                    "info": true,
                    "autoWidth": true,
//                    "order": [[4, "desc"], [5, 'asc']],
                    "sScrollY": "400",
                    "sScrollX": "100%",
                    "sScrollXInner": "250%",
                    "bScrollCollapse": true
                });
            }

            var example2 = 0;
            var example3 = 0;
            $("#tab-li_1").click(function (e) {
                if (example2 == 0) {
                    setTimeout(function () {
                        dataTableExample2();
                    }, 50);
                }
                example2++;
            });

            $("#tab-li_2").click(function (e) {
                if (example3 == 0) {
                    setTimeout(function () {
                        dataTableExample3();
                    }, 50);
                }
                example3++;
            });

            @if(Input::get('walk_in_approval') === '0' || Input::get('walk_in_approval') == 1)
            $(".tab-li, .tab-pane").removeClass('active');
            $("#tab-li_1").addClass('active');
            $("#tab_1").addClass('active');
            dataTableExample2();
            example2++;
            @endif

            @if(Input::get('type') == 1)
            $(".tab-li, .tab-pane").removeClass('active');
            $("#tab-li_0").addClass('active');
            $("#tab_0").addClass('active');
            @endif
            @if(Input::get('type') == 2)
            $(".tab-li, .tab-pane").removeClass('active');
            $("#tab-li_1").addClass('active');
            $("#tab_1").addClass('active');
            dataTableExample2();
            example2++;
            @endif
            @if(Input::get('type') == 3)
            $(".tab-li, .tab-pane").removeClass('active');
            $("#tab-li_2").addClass('active');
            $("#tab_2").addClass('active');
            dataTableExample3();
            example3++;
            @endif


            $('.datepicker2').datepicker({
                todayHighlight: true,
                autoclose: true
            });
            $('.datepicker').datepicker({
                startDate: "1d",
                todayHighlight: true,
                autoclose: true
            });

            $('.datepic_search').datepicker({
                todayHighlight: true,
                autoclose: true
            });

            $('.limit_datepicker').datepicker({
                startDate: "+0d",
                endDate: "+9d",
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
                        $("#patientName").autocomplete("destroy");
                        patientNameautocomplete('?hospital_id=' + $("#selectHospital2").val());
                        idBlur();
                    }
                });
            });
            $("#selectClinic2").change(function (e) {
                $("#selectPhysician2").attr('disabled', 'disabled');
                $.ajax({
                    url: '{{route('getPhysicianByClinicId')}}',
                    method: 'POST',
                    data: {
                        clinic_id: $(this).val()
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#selectPhysician2").removeAttr('disabled').html(data).select2();
                    }
                });
            });

            $("#selectHospital3").change(function (e) {
                $("#selectClinic3").attr('disabled', 'disabled');
                $.ajax({
                    url: '{{route('getClinicsByHospitalId')}}',
                    method: 'POST',
                    data: {
                        hospital_id: $(this).val()
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#selectClinic3").removeAttr('disabled').html(data).select2();
                        $("#id").autocomplete("destroy");
                        idautocomplete('?hospital_id=' + $("#selectHospital3").val());
                        idBlur();

                        phoneautocomplete('?hospital_id=' + $("#selectHospital3").val());
                        phoneKeyUp();

                        nationalidautocomplete('?hospital_id=' + $("#selectHospital3").val());
                        nationalidKeyUp();
                    }
                });
            });

            $("#selectClinic3").change(function (e) {
                $("#selectPhysician3").attr('disabled', 'disabled');
                $.ajax({
                    url: '{{route('getPhysicianByClinicId')}}',
                    method: 'POST',
                    data: {
                        clinic_id: $(this).val()
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#selectPhysician3").removeAttr('disabled').html(data).select2();
                    }
                });
            });

            $("#preferred_contact").change(function (e) {
                if ($(this).val() == 2) {
                    $("#email").attr('required', 'required');
                } else {
                    $("#email").removeAttr('required');
                }
            });

            function idautocomplete(param) {
                $("#id").autocomplete({
                    url: '{{route('autoCompletePatient2')}}' + param,
                    minChars: 1,
                    useCache: false,
                    filterResults: false,
                    mustMatch: true,
                    maxItemsToShow: 10,
                    remoteDataType: 'json',
                    onItemSelect: function (item) {
                        $("#id").val(item.data[0]);
                    }
                });
            }

            idautocomplete('?hospital_id=' + $("#selectHospital3").val());

            function idBlur() {
                $("#id").blur(function (e) {
                    if (!$("#id").val()) {
                        return;
                    }
                    setTimeout(function () {
                        getPatientData($("#id"));
                    }, 500);
                });
            }

            idBlur();

            function phoneautocomplete(param) {
                $("#phone").autocomplete("destroy");
                $("#phone").autocomplete({
                    url: '{{route('autoCompletePatientByPhone')}}' + param,
                    minChars: 2,
                    useCache: false,
                    filterResults: false,
                    mustMatch: false,
                    maxItemsToShow: 10,
                    remoteDataType: 'json',
                    onItemSelect: function (item) {
                        if (item.data[0]) {
                            $("#phone").val(item.data[0]);
                            $("#patient_id").val(item.data[1]);
                            setTimeout(function () {
                                getPatientData($("#patient_id"));
                            }, 500);
                        }
                    }
                });
            }

            phoneautocomplete('?hospital_id=' + $("#selectHospital3").val());

            function phoneKeyUp() {
                $("#phone").keyup(function (e) {
                    clearPatientDate();
                });
            }

            phoneKeyUp();

            function nationalidautocomplete(param) {
                $("#national_id").autocomplete("destroy");
                $("#national_id").autocomplete({
                    url: '{{route('autoCompletePatientByNationalId')}}' + param,
                    minChars: 2,
                    useCache: false,
                    filterResults: false,
                    mustMatch: false,
                    maxItemsToShow: 10,
                    remoteDataType: 'json',
                    onItemSelect: function (item) {
                        if (item.data[0]) {
                            $("#national_id").val(item.data[0]);
                            $("#patient_id").val(item.data[1]);
                            setTimeout(function () {
                                getPatientData($("#patient_id"));
                            }, 500);
                        }
                    }
                });
            }

            nationalidautocomplete('?hospital_id=' + $("#selectHospital3").val());

            function nationalidKeyUp() {
                $("#national_id").keyup(function (e) {
                    clearPatientDate();
                });
            }

            nationalidKeyUp();

            function getPatientData(opj) {
                var id = $(opj).attr('id');
                if (!$(opj).val()) {
                    return;
                }
                var input = $(opj);
                this_id = id == 'patient_id';
                this_national_id = id == 'national_id';
                $('#addWalkInReservation input').attr('disabled', 'disabled');
                $('#addWalkInReservation textarea').attr('disabled', 'disabled');
                $.ajax({
                    url: "{{route('checkPatientExist')}}",
                    method: 'POST',
                    data: {
                        search: $(opj).val(),
                        this_id: this_id,
                        this_national_id: this_national_id,
                        hospital_id: $("#selectHospital3").val()
                    },
                    success: function (data) {
                        if (!data.national_id) {
                            $('#addWalkInReservation input').removeAttr('disabled');
                            $('#addWalkInReservation textarea').removeAttr('disabled');
                            $("#patient_id").val('');
                            clearPatientDate();
                            return;
                        }
                        $("#phone").val(data.phone);
                        $("#national_id").val(data.national_id);
                        $("#id").val(data.registration_no);
                        $("#patient_id").val(data.id);
                        $("#relevant_id").val(data.relevant_type_id).select2();
                        $("#first_name").val(data.first_name);
                        $("#middle_name").val(data.middle_name);
                        $("#last_name").val(data.last_name);
                        $("#family_name").val(data.family_name);
                        $("#birthday").val(data.birthday);
                        $("#preferred_contact").val(data.preferred_contact).select2();
                        $("#email").val(data.email);
                        if (data.gender == 2) {
                            $("#female").prop("checked", false);
                            $("#male").prop("checked", true);
                        } else if (data.gender == 1) {
                            $("#female").prop("checked", true);
                            $("#male").prop("checked", false);
                        }
                        $("#address").val(data.address);
                        $('#addWalkInReservation input').removeAttr('disabled');
                        $('#addWalkInReservation textarea').removeAttr('disabled');
                        $('#id').attr('disabled', 'disabled');
                    }
                });
            }

            $("#clearData").click(function () {
                clearAllPatientDate();
            });

            function clearAllPatientDate() {
                $("#phone, #address, #patient_id, #national_id, #id, #name, #first_name, #last_name, #middle_name, #family_name, #birthday, #email, #phone2, #caller_id, #caller_name").val('');
                $("#current_patient").html('<option value="">Choose</option>').select2();
                $("#relevant_id").val('').select2();
                $("#female, #male").removeAttr('checked');
                $('#addWalkInReservation input').removeAttr('disabled');
                $('#addWalkInReservation textarea').removeAttr('disabled');
            }

            function clearPatientDate() {
                $("#address, #patient_id, #id, #name, #first_name, #last_name, #middle_name, #family_name, #birthday, #email, #phone2").val('');
                $("#current_patient").html('<option value="">Choose</option>').select2();
                $("#relevant_id").val('').select2();
                $("#female, #male").removeAttr('checked');
                $("#id").removeAttr('disabled');
            }

            $(".ask-me").click(function (e) {
                e.preventDefault();
                if (confirm('Are You Sure?')) {
                    window.location.replace($(this).attr('href'));
                }
            });

            $(document).on('click', '.cancelInfoBtn', function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $.ajax({
                    url: '{{route('getReservationData')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id
                    },
                    success: function (data) {
                        if (data) {
                            $("#modal_cancel_reason_id").html(data.reservation['cancel_reason_name']);
                            $("#modal_cancel_notes").html(data.reservation['cancel_notes']);
                            if (data.reservation['send_cancel_sms'] == 2) {
                                $("#modal_send_cancel_sms").html("No");
                            } else if (data.reservation['send_cancel_sms'] == 1) {
                                $("#modal_send_cancel_sms").html("Yes");
                            }
                            $("#modalCancelInfoReservation").modal('show');
                        }
                    }
                });
            });

            $(document).on('click', '.printResBtn', function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $("#printResAr").attr('href', '{{route('PrintReservation')}}?lang=ar&reservation_id=' + reservation_id);
                $("#printResEn").attr('href', '{{route('PrintReservation')}}?lang=en&reservation_id=' + reservation_id);
                $("#printResModal").modal('show');
            });

            $("#selectPhysician4").change(function (e) {
                $("#modal_date").val('');
                $("#modal_time").html('<option value="">Choose</option>');
            });

            $(document).on('click', '.editReserveBtn', function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $.ajax({
                    url: '{{route('editReservation')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id
                    },
                    success: function (data) {
                        if (data) {
                            $("#modal_reservation_code").html(data.reservation['code']);
                            $("#modal_patient_id").html(data.patient['registration_no']);
                            $("#modal_phone").html(data.patient['phone']);
                            $("#modal_first_name").html(data.patient['first_name']);
                            $("#modal_middle_name").html(data.patient['middle_name']);
                            $("#modal_last_name").html(data.patient['last_name']);
                            $("#modal_family_name").html(data.patient['family_name']);
                            $("#modal_birthday").html(data.patient['birthday']);
                            if (data.patient['gender'] == 2) {
                                $("#modal_gender").html("Male");
                            } else if (data.patient['gender'] == 1) {
                                $("#modal_gender").html("Female");
                            }

                            $("#modal_reservation_id").val(data.reservation['id']);
//                            $("#modal_date").val(data.reservation['date']);
//                            $("#modal_time").html(data.modal_time_html);
                            $("#modal_date").val('');
                            $("#modal_time").html('');

                            $("#selectHospital4").val(data.hospital_id).select2();
                            var clinic_id = data.reservation['clinic_id'];
                            var physician_id = data.reservation['physician_id'];
                            $.ajax({
                                url: '{{route('getClinicsByHospitalId')}}',
                                method: 'POST',
                                data: {
                                    hospital_id: data.hospital_id
                                },
                                headers: {token: '{{csrf_token()}}'},
                                success: function (data) {
                                    $("#selectClinic4").removeAttr('disabled').html(data).val(clinic_id).attr('disabled', 'disabled').select2();
                                }
                            });
                            $.ajax({
                                url: '{{route('getPhysicianByClinicId')}}',
                                method: 'POST',
                                data: {
                                    clinic_id: clinic_id
                                },
                                headers: {token: '{{csrf_token()}}'},
                                success: function (data) {
                                    $("#selectPhysician4").removeAttr('disabled').html(data).val(physician_id).select2();
                                }
                            });

                            $("#modalEditReservation").modal('show');
                        }
                    }
                });
            });

            function getAvailablePhysicianTime() {
                setTimeout(function () {
                    var modal_date = $("#modal_date").val();
                    var selectPhysician4 = $("#selectPhysician4").val();
                    if (selectPhysician4.length == 0) {
                        alert('The physician field is required!');
                        return;
                    }
                    $('#modal_time').attr('disabled', 'disabled');
                    $.ajax({
                        url: '{{route('getAvailablePhysicianTime')}}',
                        method: 'POST',
                        data: {
                            reservation_id: $("#modal_reservation_id").val(),
                            physician_id: selectPhysician4,
                            clinic_id: $("#selectClinic4").val(),
                            date: modal_date
                        },
                        success: function (data) {
                            $("#modal_time").html('<option value="">Not Available</option>').html(data.modal_time_html).removeAttr('disabled');
                        }
                    });
                }, 500);
            }

            $("#modal_date").blur(function (e) {
                getAvailablePhysicianTime();
            });

            $(document).on('click', '.revisitReserveBtn', function (e) {
//                var clinicNum = '15';
//                var patientNum = '2025';
//                responsiveVoice.speak("patient number 2025 kindly go to Dental Clinic", "US English Female", {rate: .7});
//                responsiveVoice.speak("على الحجز رقم " + patientNum + " التَّوجُّهْ إلى عيادة " + clinicNum, "Arabic Female");
                var reservation_id = $(this).attr('reservation_id');
                $("#revisit_reservation_id").val(reservation_id);
                $.ajax({
                    url: '{{route('getReservationData')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id,
                        getPhysicians: true
                    },
                    success: function (data) {
                        if (data) {
                            $("#revisit_date_div").html(data.inputDate);
                            $("#revisit_phone").html(data.patient['phone']);
                            $("#revisit_first_name").html(data.patient['first_name']);
                            $("#revisit_middle_name").html(data.patient['middle_name']);
                            $("#revisit_last_name").html(data.patient['last_name']);
                            $("#revisit_clinic_name").html(data.reservation['clinic_name']);
                            $("#revisit_clinic_id").val(data.reservation['clinic_id']);
                            $("#revisit_physician_id").html(data.physicianHtml).select2();
                            $("#formRevisitReservation").attr('action', '{{route('createRevisitReservation')}}');
                            $("#modalRevisitReservation").modal('show');
                        }
                    }
                });
            });

            $("#revisit_physician_id").change(function (e) {
                $("#revisit_date").val('');
                $("#revisit_time").html('<option value="">Choose</option>');
            });

            $(document).on('blur', '#revisit_date', function (e) {
                $("#revisit_time").attr('disabled', 'disabled');
                if ($("#revisit_physician_id").val().length == 0) {
                    alert('Please, select one physician!');
                    return;
                }
                setTimeout(function () {
                    $.ajax({
                        url: '{{route('getAvailableRevisitTime')}}',
                        method: 'POST',
                        data: {
                            reservation_id: $("#revisit_reservation_id").val(),
                            date: $("#revisit_date").val(),
                            physician_id: $("#revisit_physician_id").val(),
                            clinic_id: $("#revisit_clinic_id").val()
                        },
                        success: function (data) {
                            $("#revisit_time").html(data).removeAttr('disabled');
                        }
                    });
                }, 500);
            });

            $(document).on('click', '.editRevisitReserveBtn', function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $("#revisit_reservation_id").val(reservation_id);
                $.ajax({
                    url: '{{route('getReservationData')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id,
                        getPhysicians: true,
                        editRevisit: true
                    },
                    success: function (data) {
                        if (data) {
                            $("#revisit_date_div").html(data.inputDate);
                            $("#revisit_phone").html(data.patient['phone']);
                            $("#revisit_first_name").html(data.patient['first_name']);
                            $("#revisit_middle_name").html(data.patient['middle_name']);
                            $("#revisit_last_name").html(data.patient['last_name']);
                            $("#revisit_clinic_name").html(data.reservation['clinic_name']);
                            $("#revisit_clinic_id").val(data.reservation['clinic_id']);
                            $("#revisit_physician_id").html(data.physicianHtml).select2();
                            $("#formRevisitReservation").attr('action', '{{route('updateRevisitReservation')}}');
                            $("#modalRevisitReservation").modal('show');
                        }
                    }
                });
            });

            $("#updateReservation").submit(function (e) {
                e.preventDefault();
                var formData = getFormData($(this).serializeArray());
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: {
                        data: formData
                    },
                    success: function (data) {
                        $("#modalEditReservation").modal('hide');
                        window.location.reload();
                    }
                });
            });

            $(document).on('click', '.deleteReserveBtn', function (e) {
                if (confirm('Are You Sure?')) {
                    $("#modalCancelReservation").modal('show');
                    $("#modal_cancel_reservation_id").val($(this).attr('ref_id'));
                }
            });

            $("#modalCancelReservationBtn").click(function (e) {
                if ($("#cancel_reason_id").val() == "") {
                    alert('Cancel Reason is required');
                    return;
                }
                $.ajax({
                    url: "{{route('deleteReservation')}}",
                    method: 'POST',
                    data: {
                        reservation_id: $("#modal_cancel_reservation_id").val(),
                        cancel_notes: $("#reservation_cancel").val(),
                        cancel_reason_id: $("#cancel_reason_id").val(),
                        send_sms: $('input[name=send_sms]:checked', '#radio_sms').val(),
                        return_str: 'yes'
                    },
                    success: function (data) {
                        window.location.reload();
                    }
                });
            });

            function patientNameautocomplete(param) {
                $("#patientName").autocomplete({
                    url: '{{route('autoCompletePatientShowName')}}' + param,
                    minChars: 1,
                    useCache: false,
                    filterResults: false,
                    mustMatch: true,
                    maxItemsToShow: 10,
                    remoteDataType: 'json',
                    onItemSelect: function (item) {
                        $("#patientName").val(item.data[0]);
                    }
                });
            }

            patientNameautocomplete('?hospital_id=' + $("#selectHospital2").val());

            $(".getParentReservation").click(function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $.ajax({
                    url: '{{route('getParentReservationData')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#parent_clinic_name").html(data.reservation['clinic_name']);
                        $("#parent_physician_name").html(data.reservation['physician_name']);
                        $("#parent_code").html(data.reservation['code']);
                        $("#parent_reservation_date").html(data.reservation['date']);
                        $("#parent_reservation_time").html(data.reservation['time_from']);
                        $("#parent_patient_name").html(data.patient['name']);
                        $("#parent_patient_id").html(data.patient['registration_no']);
                        $("#parent_patient_phone").html(data.patient['phone']);
                        $("#parentReservationInfo").modal('show');
                    }
                });
            });

            $(".getRevisitReservation").click(function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $.ajax({
                    url: '{{route('getRevisitReservationData')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#revisit2_clinic_name").html(data.reservation['clinic_name']);
                        $("#revisit2_physician_name").html(data.reservation['physician_name']);
                        $("#revisit2_code").html(data.reservation['code']);
                        $("#revisit2_reservation_date").html(data.reservation['date']);
                        $("#revisit2_reservation_time").html(data.reservation['revisit_time_from']);
                        $("#revisit2_patient_name").html(data.patient['name']);
                        $("#revisit2_patient_id").html(data.patient['registration_no']);
                        $("#revisit2_patient_phone").html(data.patient['phone']);
                        $("#revisitReservationInfo").modal('show');
                    }
                });
            });

            $(".resendLastSms").click(function (e) {
                var reservation_id = $(this).attr('reservation_id');
                $.ajax({
                    url: '{{route('getReservationData')}}',
                    method: 'POST',
                    data: {
                        reservation_id: reservation_id,
                        last_sms: true
                    },
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        if (data.resend_last_sms) {
                            $("#resend_reservation_id").val('').val(data.reservation['id']);
                            $("#resend_sms_lang").val(data.reservation['sms_lang']).select2();
                            $("#resend_reservation_code").html('').html(data.reservation['code']);
                            $("#resend_reservation_date").html('').html(data.reservation['date']);
                            $("#resend_patient_name").html('').html(data.patient['name']);
                            $("#resend_patient_phone").html('').html(data.patient['phone']);
                            $("#resend_sms_type").html('').html(data.last_sms['type']);
                            $("#resend_sms_content").html('').html(data.last_sms['message']);
                            $("#resendLastSmsModal").modal('show');
                        } else {
                            alert('This Reservation Did Not Have Any SMS!');
                        }
                    }
                });
            });

            @if(Input::get('hospital_id'))
            $.ajax({
                url: '{{route('getClinicsByHospitalId')}}',
                method: 'POST',
                data: {
                    hospital_id: $("#selectHospital2").val()
                },
                headers: {token: '{{csrf_token()}}'},
                success: function (data) {
                    $("#selectClinic2").removeAttr('disabled').html(data).select2();
                    @if(Input::get('clinic_id'))
                    $("#selectClinic2").val('{{Input::get('clinic_id')}}').select2();
                    $.ajax({
                        url: '{{route('getPhysicianByClinicId')}}',
                        method: 'POST',
                        data: {
                            clinic_id: $('#selectClinic2').val()
                        },
                        headers: {token: '{{csrf_token()}}'},
                        success: function (data) {
                            $("#selectPhysician2").removeAttr('disabled').html(data).select2();
                            @if(Input::get('physician_id'))
                            $("#selectPhysician2").val('{{Input::get('physician_id')}}').select2();
                            @endif
                        }
                    });
                    @endif
                }
            });
                    @endif
                    @if(Session::get('next_patient_flag') == 1)
            var buttonUrl = $("#next_patient").attr('href');
            $("#next_patient").removeAttr('href');
            $("#next_patient").attr('disabled', 'disabled');
            setTimeout(function () {
                $("#next_patient").removeAttr('disabled');
                $("#next_patient").attr('href', buttonUrl);
            }, 60000);
            @endif


            @if(Input::has('today_only') && Input::get('today_only') == 1)
            setInterval(function () {
                var urlParams;
                (window.onpopstate = function () {
                    var match,
                        pl = /\+/g,  // Regex for replacing addition symbol with a space
                        search = /([^&=]+)=?([^&]*)/g,
                        decode = function (s) {
                            return decodeURIComponent(s.replace(pl, " "));
                        },
                        query = window.location.search.substring(1);

                    urlParams = {};
                    while (match = search.exec(query))
                        urlParams[decode(match[1])] = decode(match[2]);
                })();
                var params = jQuery.param(urlParams);
                $.ajax({
                    url: '{{route('getReservationTotalCountRefresh')}}?' + params,
                    method: 'POST',
                    headers: {token: '{{csrf_token()}}'},
                    success: function (data) {
                        $("#total_count_refresh").html(data);
                    }
                });
            }, 3000);
            @endif





        });
    </script>
@stop

@section('content')
    <section class="content-header">
        <h1>
            Reservations
        </h1>
    </section>

    <section class="content">
        <div class="row">
            @if($c_user->user_type_id == \core\enums\UserRules::patientRelation)
                <div class="col-md-2" style="margin: 10px 0;">
                    <a href="{{route('home')}}" class="btn btn-danger">Back</a>
                </div>
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            Search
                            <button type="button" class="btn btn-box-tool pull-right"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-header -->
                        {{Form::open(array('role'=>"form",'method' => 'GET', 'route' => 'manageClinicReservations'))}}
                        <div class="box-body">
                            <div class="form-group col-md-3">
                                <label>Hospital</label>
                                <br>
                                <select autocomplete="off" id="selectHospital2" name="hospital_id"
                                        class="form-control select2">
                                    @foreach($hospitals as $val)
                                        <option value="{{$val['id']}}" @if(Input::get('hospital_id') == $val['id'])
                                        selected @endif>{{$val['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Patient Name or Id</label>
                                <input autocomplete="off" id="patientName" type="text" name="name" class="form-control">
                                <input type="hidden" name="date_from" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="date_to" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="status" value="1">
                                <input type="hidden" name="patient_attend" value="0">
                            </div>

                            <div class="form-group col-md-3">
                                <label>Patient Phone</label>
                                <input autocomplete="off" type="text" name="phone" class="form-control">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            @endif
            @if($c_user->user_type_id != \core\enums\UserRules::patientRelation)
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            Search
                            <button type="button" class="btn btn-box-tool pull-right"
                                    data-widget="collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-header -->
                        {{Form::open(array('role'=>"form",'method' => 'GET'))}}
                        <div class="box-body">
                            <div class="form-group col-md-3">
                                <label>Hospital</label>
                                <br>
                                <select autocomplete="off" id="selectHospital2" name="hospital_id"
                                        class="form-control select2">
                                    <option value="">Choose</option>
                                    @foreach($hospitals as $val)
                                        <option value="{{$val['id']}}" @if(Input::get('hospital_id') == $val['id'])
                                        selected @endif>{{$val['name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label>Clinic</label>
                                <br>
                                <select autocomplete="off" id="selectClinic2" name="clinic_id"
                                        class="form-control select2">
                                    <option value="">Choose</option>
                                </select>
                            </div>
                            @if(Input::has('today_only') && Input::get('today_only') == 1)
                                <input type="hidden" name="date_from" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="date_to" value="{{date('Y-m-d')}}">
                                <input type="hidden" name="today_only" value="1">
                            @endif
                            @if(!Input::has('today_only') || Input::get('today_only') != 1)
                                <div class="form-group col-md-3">
                                    <label>Physician Name</label>
                                    <br>
                                    <select id="selectPhysician2" name="physician_id" class="form-control select2">
                                        <option value="">Choose</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Reservation Code</label>
                                    <input type="text" name="code" value="{{Input::get('code')}}"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Patient Id</label>
                                    <input type="text" name="id" value="{{Input::get('id')}}" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Patient Phone</label>
                                    <input type="text" maxlength="15" name="phone" value="{{Input::get('phone')}}"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Patient Name</label>
                                    <input type="text" name="name" value="{{Input::get('name')}}" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>National Id</label>
                                    <input type="text" name="national_id" value="{{Input::get('national_id')}}"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-3" style="margin-bottom: 5px">
                                    <label>Date From</label>
                                    <input type="text" data-date-format="yyyy-mm-dd" value="{{Input::get('date_from')}}"
                                           name="date_from" class="form-control datepic_search">
                                </div>
                                <div class="form-group col-md-3" style="margin-bottom: 5px">
                                    <label>Date To</label>
                                    <input type="text" data-date-format="yyyy-mm-dd" value="{{Input::get('date_to')}}"
                                           name="date_to" class="form-control datepic_search">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Time From</label>
                                    <div class="bootstrap-timepicker">
                                        <input autocomplete="off" type="text"
                                               value="{{Input::get('time_from')}}" name="time_from"
                                               class="form-control timepicker">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Time To</label>
                                    <div class="bootstrap-timepicker">
                                        <input autocomplete="off" type="text"
                                               value="{{Input::get('time_to')}}" name="time_to"
                                               class="form-control timepicker">
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Reservation Status</label>
                                    <br>
                                    <select autocomplete="off" name="status"
                                            class="form-control select2">
                                        <option value="">Choose</option>
                                        <option @if(Input::get('status') == 1) selected @endif value="1">Reserved
                                        </option>
                                        <option @if(Input::get('status') == 2) selected @endif value="2">On Progress
                                        </option>
                                        <option @if(Input::get('status') == 3) selected @endif value="3">Cancel</option>
                                        <option @if(Input::get('status') == 4) selected @endif value="4">Accomplished
                                        </option>
                                        <option @if(Input::get('status') == 5) selected @endif value="5">No Show
                                        </option>
                                        <option @if(Input::get('status') == 8) selected @endif value="8">Archive
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Patient Status</label>
                                    <br>
                                    <select autocomplete="off" name="patient_status"
                                            class="form-control select2">
                                        <option value="">Choose</option>
                                        <option @if(Input::get('patient_status') === "0") selected @endif value="0">
                                            Waiting
                                        </option>
                                        <option @if(Input::get('patient_status') == 10) selected @endif value="10">
                                            Patient
                                            Attend
                                        </option>
                                        <option @if(Input::get('patient_status') == 1) selected @endif value="1">Patient
                                            In
                                        </option>
                                        <option @if(Input::get('patient_status') == 2) selected @endif value="2">Patient
                                            Out
                                        </option>
                                        <option @if(Input::get('patient_status') == 4) selected @endif value="4">Cancel
                                        </option>
                                        <option @if(Input::get('patient_status') == 5) selected @endif value="5">Pending
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Walk In Approval</label>
                                    <br>
                                    <select autocomplete="off" name="walk_in_approval"
                                            class="form-control select2">
                                        <option value="">Choose</option>
                                        <option @if(Input::get('walk_in_approval') === "0") selected @endif value="0">
                                            Not Yet
                                        </option>
                                        <option @if(Input::get('walk_in_approval') == 1) selected @endif value="1">
                                            Approved
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Reservation Type</label>
                                    <br>
                                    <select autocomplete="off" name="type"
                                            class="form-control select2">
                                        <option value="">Choose</option>
                                        <option @if(Input::get('type') == 1) selected @endif value="1">
                                            By Call
                                        </option>
                                        <option @if(Input::get('type') == 2) selected @endif value="2">
                                            Wait
                                        </option>
                                        <option @if(Input::get('type') == 3) selected @endif value="3">
                                            Revisit
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Created By</label>
                                    <select autocomplete="off" name="created_by"
                                            class="form-control select2">
                                        <option value="">Choose</option>
                                        @foreach($groups as $val)
                                            <option value="{{$val['name']}}"
                                                    @if(Input::get('created_by') == $val['name'])
                                                    selected @endif>{{$val['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-primary" type="submit">Search</button>
                            @if(!Input::has('today_only') || Input::get('today_only') != 1)
                                <a href="{{route('manageClinicReservations')}}?hospital_id={{Input::get('hospital_id')}}&clinic_id={{Input::get('clinic_id')}}&date_from={{date('Y-m-d')}}&date_to={{date('Y-m-d')}}"
                                   class="btn btn-info">Clear</a>
                                <a href="{{route('reservationManage')}}" class="btn btn-danger">Back</a>
                            @endif
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="col-md-12">
                    @if($c_user->user_type_id != \core\enums\UserRules::patientRelation)
                        <div class="col-md-2" style="margin: 10px 0;">
                            {{Form::open(array('role'=>"form", 'route' => 'printExcelManageClinicReservations'))}}
                            @if(Input::except('_token'))
                                @foreach(Input::except('_token') as $key => $val)
                                    <input type="hidden" name="{{$key}}" value="{{$val}}">
                                @endforeach
                            @endif
                            <button class="btn btn-primary" type="submit">Download Excel</button>
                            {{Form::close()}}
                        </div>
                        <div class="col-md-8" style="margin: 10px 0;">
                            <button class="btn" style="background: #84e184">Patient Attend</button>
                            <button class="btn" style="background: #32cd32">Patient In</button>
                            <button class="btn" style="background: deepskyblue">Patient Out</button>
                            <button class="btn" style="background: #ff8566">Cancel, NoShow, Archive</button>
                            <button class="btn" style="background: #ffb84d">Pending</button>
                        </div>
                        @if($c_user->user_type_id == \core\enums\UserRules::physician && $c_user->hasAccess('manageReservation.nextPatientBtn'))
                            <div class="col-md-2" style="margin: 10px 0;">
                                <a id="next_patient" href="{{route('nextPatientInReservation')}}"
                                   class="btn btn-primary">Next Patient</a>
                            </div>
                            @if(Input::has('today_only') && Input::get('today_only') == 1)
                                <div class="col-md-12" style="margin: 10px 0;" id="total_count_refresh">
                                    {{$total_count_refresh}}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li id="tab-li_0" class="tab-li active"><a href="#tab_0" data-toggle="tab">Reservations</a></li>
                        @if($c_user->user_type_id != \core\enums\UserRules::patientRelation)
                            <li id="tab-li_1" class="tab-li"><a href="#tab_1" data-toggle="tab">Waiting List</a>
                            </li>
                            <li id="tab-li_2" class="tab-li"><a href="#tab_2" data-toggle="tab">Revisit List</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content col-md-12">
                        <div class="tab-pane active" id="tab_0">
                            <div class="col-md-12">
                                <div class="">
                                    <table class="table table-bordered example1" id="example1">
                                        <thead>
                                        <tr>
                                            <th>Options</th>
                                            <th>Clinic Name</th>
                                            <th>Physician Name</th>
                                            <th>Patient Name</th>
                                            <th>Date</th>
                                            <th>Time From</th>
                                            <th>Time To</th>
                                            <th>P National ID</th>
                                            <th>Patient Phone</th>
                                            <th>Patient ID</th>
                                            <th>Reservation Code</th>
                                            <th>Reservation Status</th>
                                            <th>Patient Status</th>
                                            <th>Revisits Count</th>
                                            @if($c_user->user_type_id == 1 || $c_user->hasAccess('supervisor.access'))
                                                <th>Create By</th>
                                                <th>Create At</th>
                                                <th>Update By</th>
                                                <th>Update At</th>
                                            @endif
                                            <th>CC Notes</th>
                                            <th>Ex Reason</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($reservations as $key => $val)
                                            @if($val['type'] != 1)
                                                <?php continue; ?>
                                            @endif
                                            <?php
                                            $physician = User::getById($val['physician_id']);
                                            $patient = Patient::getById($val['patient_id']);
                                            $count_revisit = Reservation::countRevisitOfReservation($val['id'])
                                            ?>
                                            <tr style="
                                            @if($val['patient_attend'] == 1)
                                                    background:#84e184;
                                            @endif
                                            @if($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                    background:#32cd32;
                                            @endif
                                            @if($val['patient_status'] == \core\enums\PatientStatus::patient_out)
                                                    background:deepskyblue;
                                            @endif
                                            @if($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                    background:#ff8566;
                                            @endif
                                            @if($val['patient_status'] == \core\enums\PatientStatus::no_show)
                                                    background:#ff8566;
                                            @endif
                                            @if($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                    background:#ffb84d;
                                            @endif
                                            @if($val['patient_status'] == \core\enums\PatientStatus::archive)
                                                    background:#ff8566;
                                            @endif">
                                                <td>
                                                    <div class="btn-group" style="width: 220px;">
                                                        @if($c_user->user_type_id == 1 || $c_user->hasAccess('reservation.note'))
                                                            <a ref_id="{{$val['id']}}" title="Add Notes"
                                                               class="btn btn-default noteReserveBtn"><i
                                                                        class="fa fa-sticky-note-o"></i></a>
                                                        @endif

                                                        @if($c_user->hasAccess('manageReservation.printRes') || $c_user->user_type_id == 1)
                                                            <a reservation_id="{{$val['id']}}"
                                                               title="Print Reservation"
                                                               class="btn btn-warning printResBtn"><i
                                                                        class="fa fa-print"></i></a>
                                                        @endif
                                                        @if($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                            <a reservation_id="{{$val['id']}}"
                                                               title="Cancellation Info"
                                                               class="btn btn-info cancelInfoBtn"><i
                                                                        class="fa fa-search"></i></a>
                                                        @endif
                                                        @if($val['date'] < date('Y-m-d'))
                                                            @if($physician['revisit_limit'] && $val['patient_attend'] == 1
                                                        && $count_revisit == 0
                                                        && ($c_user->hasAccess('manageReservation.revisit') || $c_user->user_type_id == 1))
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Revisit"
                                                                   class="btn btn-default revisitReserveBtn"><i
                                                                            class="fa fa-repeat"></i></a>
                                                            @endif
                                                        @else
                                                            @if($val['patient_status'] == \core\enums\PatientStatus::waiting)
                                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_attend'))
                                                                    <a @if($val['patient_attend'] == 0)
                                                                       title="Patient Attend"
                                                                       @else
                                                                       title="Patient Not Attend"
                                                                       @endif
                                                                       class="btn btn-default ask-me"
                                                                       href="{{route('managePatientAttendReservation', $val['id'])}}">
                                                                        @if($val['patient_attend'] == 0)
                                                                            <i class="fa fa-check-circle"></i>
                                                                        @else
                                                                            <i class="fa fa-circle-thin"></i>
                                                                        @endif
                                                                    </a>
                                                                @endif
                                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_in'))
                                                                    @if($val['patient_attend'] == 1 && User::getById($val['physician_id'])['is_ready'] == 1)
                                                                        <a class="btn btn-default ask-me"
                                                                           title="Patient In"
                                                                           href="{{route('managePatientReservation', array($val['id'], \core\enums\PatientStatus::patient_in))}}">
                                                                            <i class="fa fa-arrow-down"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_pending_resume'))
                                                                    <a class="btn btn-warning ask-me" title="Pending"
                                                                       href="{{route('changeStatusPatientReservation', array($val['id'], \core\enums\PatientStatus::pending))}}">
                                                                        <i class="fa fa-exclamation"></i>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            @if($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_out'))
                                                                    <a class="btn btn-danger ask-me" title="Patient Out"
                                                                       href="{{route('managePatientReservation', array($val['id'], \core\enums\PatientStatus::patient_out))}}">
                                                                        <i class="fa fa-arrow-up"></i>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            @if($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_pending_resume'))
                                                                    <a class="btn btn-default ask-me" title="Resume"
                                                                       href="{{route('changeStatusPatientReservation', array($val['id'], \core\enums\PatientStatus::waiting))}}">
                                                                        <i class="fa fa-check"></i>
                                                                    </a>
                                                                @endif
                                                            @endif
                                                            @if(($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                            || $val['patient_status'] == \core\enums\PatientStatus::pending
                                                            || $val['patient_status'] == \core\enums\PatientStatus::archive)
                                                            && ($c_user->hasAccess('reservation.edit') || $c_user->user_type_id == 1))
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Edit"
                                                                   class="btn btn-default editReserveBtn"><i
                                                                            class="fa fa-pencil"></i></a>
                                                            @endif
                                                            @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                                        || $val['patient_status'] == \core\enums\PatientStatus::pending)
                                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_cancel'))
                                                                    <a ref_id="{{$val['id']}}" title="Cancel"
                                                                       class="btn btn-danger deleteReserveBtn"><i
                                                                                class="fa fa-times"></i></a>
                                                                @endif
                                                            @endif
                                                            @if($physician['revisit_limit']
                                                            && $count_revisit == 0 && $val['patient_attend']
                                                            && ($c_user->hasAccess('manageReservation.revisit') || $c_user->user_type_id == 1))
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Revisit"
                                                                   class="btn btn-default revisitReserveBtn"><i
                                                                            class="fa fa-repeat"></i></a>
                                                            @endif
                                                            @if(($c_user->hasAccess('manageReservation.resend_last_sms') || $c_user->user_type_id == 1)
                                                            && ($val['patient_status'] == \core\enums\PatientStatus::cancel
                                                            || $val['patient_status'] == \core\enums\PatientStatus::pending
                                                            || $val['patient_status'] == \core\enums\PatientStatus::waiting))
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Resend Last SMS"
                                                                   class="btn btn-info resendLastSms"><i
                                                                            class="fa fa-reply"></i></a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>

                                                <td>{{Clinic::getNameById($val['clinic_id'])}}</td>
                                                <td>
                                                    <div>
                                                        {{ucwords(strtolower($physician['full_name']))}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        {{ucwords(strtolower($patient['name']))}}
                                                    </div>
                                                </td>
                                                <td>{{$val['date']}}</td>
                                                <td>
                                                    <?php
                                                    if ($val['time_from'] > '23:59:00') {
                                                        $seconds = Functions::hoursToSeconds($val['time_from']);
                                                        $newSeconds = $seconds - (24 * 60 * 60);
                                                        $val['time_from'] = Functions::timeFromSeconds($newSeconds);
                                                    }
                                                    ?>
                                                    {{$val['time_from']}}
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($val['time_to'] > '23:59:00') {
                                                        $seconds = Functions::hoursToSeconds($val['time_to']);
                                                        $newSeconds = $seconds - (24 * 60 * 60);
                                                        $val['time_to'] = Functions::timeFromSeconds($newSeconds);
                                                    }
                                                    ?>
                                                    {{$val['time_to']}}
                                                </td>
                                                <td>{{$patient['national_id']}}</td>
                                                <td>{{$patient['phone']}}</td>
                                                <td>{{$patient['registration_no']}}</td>
                                                <td>{{$val['code']}}</td>
                                                <td>
                                                    @if($val['status'] == \core\enums\ReservationStatus::reserved)
                                                        Reserved
                                                    @elseif($val['status'] == \core\enums\ReservationStatus::accomplished)
                                                        Accomplished
                                                    @elseif($val['status'] == \core\enums\ReservationStatus::cancel)
                                                        <span>Cancel</span>
                                                    @elseif($val['status'] == \core\enums\ReservationStatus::on_progress)
                                                        On Progress
                                                    @elseif($val['status'] == \core\enums\ReservationStatus::no_show)
                                                        <span>No Show</span>
                                                    @elseif($val['status'] == \core\enums\ReservationStatus::pending)
                                                        <span>Pending</span>
                                                    @elseif($val['status'] == \core\enums\ReservationStatus::archive)
                                                        <span>Archive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($val['patient_status'] == \core\enums\PatientStatus::waiting)
                                                        @if($val['patient_attend'] == 1)
                                                            <span>Patient Attend</span>
                                                        @else
                                                            Waiting
                                                        @endif
                                                    @elseif($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                        Patient In
                                                    @elseif($val['patient_status'] == \core\enums\PatientStatus::patient_out)
                                                        Patient Out
                                                    @elseif($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                        <span>Cancel</span>
                                                    @elseif($val['patient_status'] == \core\enums\PatientStatus::no_show)
                                                        <span>No Show</span>
                                                    @elseif($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                        <span>Pending</span>
                                                    @elseif($val['patient_status'] == \core\enums\PatientStatus::archive)
                                                        <span>Archive</span>
                                                    @endif
                                                </td>
                                                @if($count_revisit == 0)
                                                    <td>
                                                        {{$count_revisit}}
                                                    </td>
                                                @else
                                                    <td class="getRevisitReservation"
                                                        reservation_id="{{$val['id']}}"
                                                        style="text-decoration:underline;color:blue;cursor: pointer;">{{$count_revisit}}</td>
                                                @endif
                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('supervisor.access'))
                                                    <td>
                                                        <div>
                                                            <?php
                                                            if ($val['create_by']) {
                                                                $oneUser = Sentry::findUserById($val['create_by']);
                                                                $groups = $oneUser->getGroups();
                                                                $count = count($groups);
                                                                $create_by = User::getName($val['create_by']) . ' (';
                                                                foreach ($groups as $index2 => $val2) {
                                                                    if ($count == $index2 + 1) {
                                                                        $create_by .= $val2['name'] . ')';
                                                                    } else {
                                                                        $create_by .= $val2['name'] . ', ';
                                                                    }
                                                                }
                                                            } else {
                                                                $create_by = User::getName($val['create_by']);
                                                            }
                                                            ?>
                                                            {{$create_by}}
                                                        </div>
                                                    </td>
                                                    <td>{{$val['created_at']}}</td>
                                                    <td>
                                                        <div>
                                                            <?php
                                                            if ($val['update_by']) {
                                                                $oneUser = Sentry::findUserById($val['update_by']);
                                                                $groups = $oneUser->getGroups();
                                                                $count = count($groups);
                                                                $update_by = User::getName($val['update_by']) . ' (';
                                                                foreach ($groups as $index2 => $val2) {
                                                                    if ($count == $index2 + 1) {
                                                                        $update_by .= $val2['name'] . ')';
                                                                    } else {
                                                                        $update_by .= $val2['name'] . ', ';
                                                                    }
                                                                }
                                                            } else {
                                                                $update_by = User::getName($val['update_by']);
                                                            }
                                                            ?>
                                                            {{$update_by}}
                                                        </div>
                                                    </td>
                                                    <td>{{$val['updated_at']}}</td>
                                                @endif
                                                <td>
                                                    <div style="width: 150px;cursor: pointer;" class="showPopover"
                                                         data-container="body"
                                                         data-toggle="popover" data-placement="top"
                                                         data-content="{{nl2br($val['notes'])}}">
                                                        {{$val['notes'] ? Functions::num_words($val['notes']) : ''}}...
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($val['patient_status'] == \core\enums\PatientStatus::pending
                                                    || $val['patient_status'] == \core\enums\PatientStatus::no_show
                                                    || $val['patient_status'] == \core\enums\PatientStatus::cancel
                                                    || $val['patient_status'] == \core\enums\PatientStatus::archive)
                                                        {{$val['exception_reason']}}
                                                    @endif
                                                </td>
                                            </tr>
                                            <?php unset($reservations[$key]); ?>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$reservations->appends(Input::except('_token'))->links()}}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_1">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.walkIn_add'))
                                        <a data-target="#addWalkInReservation" data-toggle="modal"
                                           class="btn btn-default">Add
                                            Reservation</a>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="">
                                        <table class="table table-bordered example1" id=example2>
                                            <thead>
                                            <tr>
                                                <th>Options</th>
                                                <th>Clinic Name</th>
                                                <th>Physician Name</th>
                                                <th>Patient Name</th>
                                                <th>Date</th>
                                                <th>P National ID</th>
                                                <th>Patient Phone</th>
                                                <th>Patient ID</th>
                                                <th>Approved?</th>
                                                <th>Reservation Code</th>
                                                <th>Reservation Status</th>
                                                <th>Patient Status</th>
                                                {{--<th>WalkIn Type</th>--}}
                                                <th>Duration</th>
                                                <th>Revisits Count</th>
                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('supervisor.access'))
                                                    <th>Create By</th>
                                                    <th>Create At</th>
                                                    <th>Update By</th>
                                                    <th>Update At</th>
                                                @endif
                                                <th>CC Notes</th>
                                                <th>Ex Reason</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reservations as $key => $val)
                                                @if($val['type'] != 2)
                                                    <?php continue; ?>
                                                @endif
                                                <?php
                                                $physician = User::getById($val['physician_id']);
                                                $patient = Patient::getById($val['patient_id']);
                                                $count_revisit = Reservation::countRevisitOfReservation($val['id'])
                                                ?>
                                                <tr style="
                                                @if($val['patient_attend'] == 1)
                                                        background:#84e184;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                        background:#32cd32;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::patient_out)
                                                        background:deepskyblue;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                        background:#ff8566;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::no_show)
                                                        background:#ff8566;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                        background:#ffb84d;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::archive)
                                                        background:#ff8566;
                                                @endif">
                                                    <td>
                                                        <div class="btn-group" style="width: 220px;">

                                                            @if($c_user->user_type_id == 1 || $c_user->hasAccess('reservation.note'))
                                                                <a ref_id="{{$val['id']}}" title="Add Notes"
                                                                   class="btn btn-default noteReserveBtn"><i
                                                                            class="fa fa-sticky-note-o"></i></a>
                                                            @endif

                                                            @if($c_user->hasAccess('manageReservation.printRes') || $c_user->user_type_id == 1)
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Print Reservation"
                                                                   class="btn btn-warning printResBtn"><i
                                                                            class="fa fa-print"></i></a>
                                                            @endif
                                                            @if($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Cancellation Info"
                                                                   class="btn btn-info cancelInfoBtn"><i
                                                                            class="fa fa-search"></i></a>
                                                            @endif
                                                            @if($val['date'] < date('Y-m-d'))
                                                                @if($physician['revisit_limit'] && $val['patient_attend'] == 1
                                                            && $count_revisit == 0 && $val['walk_in_approval'] == '1'
                                                            && ($c_user->hasAccess('manageReservation.revisit') || $c_user->user_type_id == 1))
                                                                    <a reservation_id="{{$val['id']}}"
                                                                       title="Revisit"
                                                                       class="btn btn-default revisitReserveBtn"><i
                                                                                class="fa fa-repeat"></i></a>
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                            && $val['walk_in_approval'] == '0'
                                                            && $c_user->user_type_id == \core\enums\UserRules::clinicManager)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.waitListApproval'))
                                                                        <a class="btn btn-flickr ask-me"
                                                                           title="Approved"
                                                                           href="{{route('approvedWalkInReservation', $val['id'])}}">
                                                                            <i class="fa fa-calendar-check-o"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                            @else
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting && $val['walk_in_approval'] == '1')
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_attend'))
                                                                        <a @if($val['patient_attend'] == 0)
                                                                           title="Patient Attend"
                                                                           @else
                                                                           title="Patient Not Attend"
                                                                           @endif
                                                                           class="btn btn-default ask-me"
                                                                           href="{{route('managePatientAttendReservation', $val['id'])}}">
                                                                            @if($val['patient_attend'] == 0)
                                                                                <i class="fa fa-check-circle"></i>
                                                                            @else
                                                                                <i class="fa fa-circle-thin"></i>
                                                                            @endif
                                                                        </a>
                                                                    @endif
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_in'))
                                                                        @if($val['patient_attend'] == 1 && User::getById($val['physician_id'])['is_ready'] == 1)
                                                                            <a class="btn btn-default ask-me"
                                                                               title="Patient In"
                                                                               href="{{route('managePatientReservation', array($val['id'], \core\enums\PatientStatus::patient_in))}}">
                                                                                <i class="fa fa-arrow-down"></i>
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                                        || $val['patient_status'] == \core\enums\PatientStatus::pending)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_cancel'))
                                                                        <a ref_id="{{$val['id']}}" title="Cancel"
                                                                           class="btn btn-danger deleteReserveBtn"><i
                                                                                    class="fa fa-times"></i></a>
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_out'))
                                                                        <a class="btn btn-danger ask-me"
                                                                           title="Patient Out"
                                                                           href="{{route('managePatientReservation', array($val['id'], \core\enums\PatientStatus::patient_out))}}">
                                                                            <i class="fa fa-arrow-up"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_pending_resume'))
                                                                        <a class="btn btn-default ask-me" title="Resume"
                                                                           href="{{route('changeStatusPatientReservation', array($val['id'], \core\enums\PatientStatus::waiting))}}">
                                                                            <i class="fa fa-check"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                                || $val['patient_status'] == \core\enums\PatientStatus::pending
                                                                || $val['patient_status'] == \core\enums\PatientStatus::archive
                                                                && ($c_user->hasAccess('reservation.edit') || $c_user->user_type_id == 1))
                                                                    <a reservation_id="{{$val['id']}}"
                                                                       title="Edit"
                                                                       class="btn btn-default editReserveBtn"><i
                                                                                class="fa fa-pencil"></i></a>
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                                && $val['walk_in_approval'] == '0')
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.waitListApproval'))
                                                                        <a class="btn btn-flickr ask-me"
                                                                           title="Approved"
                                                                           href="{{route('approvedWalkInReservation', $val['id'])}}">
                                                                            <i class="fa fa-calendar-check-o"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if($physician['revisit_limit']
                                                                    && $count_revisit == 0 && $val['walk_in_approval'] == '1'
                                                                    && ($c_user->hasAccess('manageReservation.revisit') || $c_user->user_type_id == 1))
                                                                    <a reservation_id="{{$val['id']}}"
                                                                       title="Revisit"
                                                                       class="btn btn-default revisitReserveBtn"><i
                                                                                class="fa fa-repeat"></i></a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{Clinic::getNameById($val['clinic_id'])}}</td>
                                                    <td>
                                                        <div>
                                                            {{ucwords(strtolower($physician['full_name']))}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ucwords(strtolower($patient['name']))}}
                                                        </div>
                                                    </td>
                                                    <td>{{$val['date']}}</td>
                                                    <td>{{$patient['national_id']}}</td>
                                                    <td>{{$patient['phone']}}</td>
                                                    <td>{{$patient['registration_no']}}</td>
                                                    <td>{{$val['walk_in_approval'] ? 'Yes' : 'Not Yet'}}</td>
                                                    <td>{{$val['code']}}</td>
                                                    <td>
                                                        @if($val['status'] == \core\enums\ReservationStatus::reserved)
                                                            Reserved
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::accomplished)
                                                            Accomplished
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::cancel)
                                                            <span>Cancel</span>
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::on_progress)
                                                            On Progress
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::no_show)
                                                            <span>No Show</span>
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::pending)
                                                            <span>Pending</span>
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::archive)
                                                            <span>Archive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($val['patient_status'] == \core\enums\PatientStatus::waiting)
                                                            @if($val['patient_attend'] == 1)
                                                                <span>Patient Attend</span>
                                                            @else
                                                                Waiting
                                                            @endif
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                            Patient In
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::patient_out)
                                                            Patient Out
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                            <span>Cancel</span>
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::no_show)
                                                            <span>No Show</span>
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                            <span>Pending</span>
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::archive)
                                                            <span>Archive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$val['walk_in_duration']}}</td>
                                                    @if($count_revisit == 0)
                                                        <td>
                                                            {{$count_revisit}}
                                                        </td>
                                                    @else
                                                        <td class="getRevisitReservation"
                                                            reservation_id="{{$val['id']}}"
                                                            style="text-decoration:underline;color:blue;cursor: pointer;">{{$count_revisit}}</td>
                                                    @endif
                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('supervisor.access'))
                                                        <td>
                                                            <div>
                                                                <?php
                                                                if ($val['create_by']) {
                                                                    $oneUser = Sentry::findUserById($val['create_by']);
                                                                    $groups = $oneUser->getGroups();
                                                                    $count = count($groups);
                                                                    $create_by = User::getName($val['create_by']) . ' (';
                                                                    foreach ($groups as $index2 => $val2) {
                                                                        if ($count == $index2 + 1) {
                                                                            $create_by .= $val2['name'] . ')';
                                                                        } else {
                                                                            $create_by .= $val2['name'] . ', ';
                                                                        }
                                                                    }
                                                                } else {
                                                                    $create_by = User::getName($val['create_by']);
                                                                }
                                                                ?>
                                                                {{$create_by}}
                                                            </div>
                                                        </td>
                                                        <td>{{$val['created_at']}}</td>
                                                        <td>
                                                            <div>
                                                                <?php
                                                                if ($val['update_by']) {
                                                                    $oneUser = Sentry::findUserById($val['update_by']);
                                                                    $groups = $oneUser->getGroups();
                                                                    $count = count($groups);
                                                                    $update_by = User::getName($val['update_by']) . ' (';
                                                                    foreach ($groups as $index2 => $val2) {
                                                                        if ($count == $index2 + 1) {
                                                                            $update_by .= $val2['name'] . ')';
                                                                        } else {
                                                                            $update_by .= $val2['name'] . ', ';
                                                                        }
                                                                    }
                                                                } else {
                                                                    $update_by = User::getName($val['update_by']);
                                                                }
                                                                ?>
                                                                {{$update_by}}
                                                            </div>
                                                        </td>
                                                        <td>{{$val['updated_at']}}</td>
                                                    @endif
                                                    <td>
                                                        <div style="width: 150px;cursor: pointer;" class="showPopover"
                                                             data-container="body"
                                                             data-toggle="popover" data-placement="top"
                                                             data-content="{{nl2br($val['notes'])}}">
                                                            {{$val['notes'] ? Functions::num_words($val['notes']) : ''}}...
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($val['patient_status'] == \core\enums\PatientStatus::pending
                                                    || $val['patient_status'] == \core\enums\PatientStatus::no_show
                                                    || $val['patient_status'] == \core\enums\PatientStatus::cancel
                                                    || $val['patient_status'] == \core\enums\PatientStatus::archive)
                                                            {{$val['exception_reason']}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <?php unset($reservations[$key]); ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{$reservations->appends(Input::except('_token'))->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="">
                                        <table class="table table-bordered example1" id="example3">
                                            <thead>
                                            <tr>
                                                <th>Options</th>
                                                <th>Clinic Name</th>
                                                <th>Physician Name</th>
                                                <th>Patient Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>P National ID</th>
                                                <th>Patient Phone</th>
                                                <th>Patient ID</th>
                                                <th>Reservation Code</th>
                                                <th>Parent Code</th>
                                                <th>Reservation Status</th>
                                                <th>Patient Status</th>
                                                @if($c_user->user_type_id == 1 || $c_user->hasAccess('supervisor.access'))
                                                    <th>Create By</th>
                                                    <th>Create At</th>
                                                    <th>Update By</th>
                                                    <th>Update At</th>
                                                @endif
                                                <th>CC Notes</th>
                                                <th>Ex Reason</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($reservations as $key => $val)
                                                @if($val['type'] != 3)
                                                    <?php continue; ?>
                                                @endif
                                                <?php
                                                $patient = Patient::getById($val['patient_id']);
                                                ?>
                                                <tr style="
                                                @if($val['patient_attend'] == 1)
                                                        background:#84e184;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                        background:#32cd32;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::patient_out)
                                                        background:deepskyblue;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                        background:#ff8566;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::no_show)
                                                        background:#ff8566;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                        background:#ffb84d;
                                                @endif
                                                @if($val['patient_status'] == \core\enums\PatientStatus::archive)
                                                        background:#ff8566;
                                                @endif">
                                                    <td>
                                                        <div class="btn-group" style="width: 220px;">

                                                            @if($c_user->user_type_id == 1 || $c_user->hasAccess('reservation.note'))
                                                                <a ref_id="{{$val['id']}}" title="Add Notes"
                                                                   class="btn btn-default noteReserveBtn"><i
                                                                            class="fa fa-sticky-note-o"></i></a>
                                                            @endif

                                                            @if($c_user->hasAccess('manageReservation.printRes') || $c_user->user_type_id == 1)
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Print Reservation"
                                                                   class="btn btn-warning printResBtn"><i
                                                                            class="fa fa-print"></i></a>
                                                            @endif
                                                            @if($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                                <a reservation_id="{{$val['id']}}"
                                                                   title="Cancellation Info"
                                                                   class="btn btn-info cancelInfoBtn"><i
                                                                            class="fa fa-search"></i></a>
                                                            @endif
                                                            @if($val['date'] < date('Y-m-d'))
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::no_show
                                                                && ($c_user->hasAccess('reservation.edit') || $c_user->user_type_id == 1))
                                                                    <a reservation_id="{{$val['id']}}"
                                                                       title="Edit"
                                                                       class="btn btn-default editRevisitReserveBtn"><i
                                                                                class="fa fa-pencil"></i></a>
                                                                @endif
                                                            @else
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_attend'))
                                                                        <a @if($val['patient_attend'] == 0)
                                                                           title="Patient Attend"
                                                                           @else
                                                                           title="Patient Not Attend"
                                                                           @endif
                                                                           class="btn btn-default ask-me"
                                                                           href="{{route('managePatientAttendReservation', $val['id'])}}">
                                                                            @if($val['patient_attend'] == 0)
                                                                                <i class="fa fa-check-circle"></i>
                                                                            @else
                                                                                <i class="fa fa-circle-thin"></i>
                                                                            @endif
                                                                        </a>
                                                                    @endif
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_in'))
                                                                        @if($val['patient_attend'] == 1 && User::getById($val['physician_id'])['is_ready'] == 1)
                                                                            <a class="btn btn-default ask-me"
                                                                               title="Patient In"
                                                                               href="{{route('managePatientReservation', array($val['id'], \core\enums\PatientStatus::patient_in))}}">
                                                                                <i class="fa fa-arrow-down"></i>
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                                        || $val['patient_status'] == \core\enums\PatientStatus::pending)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_cancel'))
                                                                        <a ref_id="{{$val['id']}}" title="Cancel"
                                                                           class="btn btn-danger deleteReserveBtn"><i
                                                                                    class="fa fa-times"></i></a>
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_out'))
                                                                        <a class="btn btn-danger ask-me"
                                                                           title="Patient Out"
                                                                           href="{{route('managePatientReservation', array($val['id'], \core\enums\PatientStatus::patient_out))}}">
                                                                            <i class="fa fa-arrow-up"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('manageReservation.patient_pending_resume'))
                                                                        <a class="btn btn-default ask-me" title="Resume"
                                                                           href="{{route('changeStatusPatientReservation', array($val['id'], \core\enums\PatientStatus::waiting))}}">
                                                                            <i class="fa fa-check"></i>
                                                                        </a>
                                                                    @endif
                                                                @endif
                                                                @if($val['patient_status'] == \core\enums\PatientStatus::waiting
                                                                || $val['patient_status'] == \core\enums\PatientStatus::pending
                                                                || $val['patient_status'] == \core\enums\PatientStatus::archive
                                                                && ($c_user->hasAccess('reservation.edit') || $c_user->user_type_id == 1))
                                                                    <a reservation_id="{{$val['id']}}"
                                                                       title="Edit"
                                                                       class="btn btn-default editRevisitReserveBtn"><i
                                                                                class="fa fa-pencil"></i></a>
                                                                @endif
                                                                @if(($c_user->hasAccess('manageReservation.resend_last_sms') || $c_user->user_type_id == 1)
                                                                && ($val['patient_status'] == \core\enums\PatientStatus::cancel
                                                                || $val['patient_status'] == \core\enums\PatientStatus::pending
                                                                || $val['patient_status'] == \core\enums\PatientStatus::waiting))
                                                                    <a reservation_id="{{$val['id']}}"
                                                                       title="Resend Last SMS"
                                                                       class="btn btn-info resendLastSms"><i
                                                                                class="fa fa-reply"></i></a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>{{Clinic::getNameById($val['clinic_id'])}}</td>
                                                    <td>
                                                        <div>
                                                            {{ucwords(strtolower(User::getName($val['physician_id'])))}}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            {{ucwords(strtolower($patient['name']))}}
                                                        </div>
                                                    </td>
                                                    <td>{{$val['date']}}</td>
                                                    <td>
                                                        <?php
                                                        $seconds = Functions::hoursToSeconds($val['revisit_time_from']);
                                                        $newSeconds = $seconds + (10 * 60);
                                                        $futureTime = Functions::timeFromSeconds($newSeconds);
                                                        ?>
                                                        {{$futureTime}}
                                                    </td>
                                                    <td>{{$patient['national_id']}}</td>
                                                    <td>{{$patient['phone']}}</td>
                                                    <td>{{$patient['registration_no']}}</td>
                                                    <td>{{$val['code']}}</td>
                                                    @if($val['parent_id_of_revisit'])
                                                        <td class="getParentReservation" reservation_id="{{$val['id']}}"
                                                            style="text-decoration:underline;color:blue;cursor: pointer;">
                                                            {{Reservation::getById($val['parent_id_of_revisit'])['code']}}
                                                        </td>
                                                    @else
                                                        <td>
                                                            <span style="color:green;">Stand Alone</span>
                                                        </td>
                                                    @endif
                                                    <td>
                                                        @if($val['status'] == \core\enums\ReservationStatus::reserved)
                                                            Reserved
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::accomplished)
                                                            Accomplished
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::cancel)
                                                            <span>Cancel</span>
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::on_progress)
                                                            On Progress
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::no_show)
                                                            <span>No Show</span>
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::pending)
                                                            <span>Pending</span>
                                                        @elseif($val['status'] == \core\enums\ReservationStatus::archive)
                                                            <span>Archive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($val['patient_status'] == \core\enums\PatientStatus::waiting)
                                                            @if($val['patient_attend'] == 1)
                                                                <span>Patient Attend</span>
                                                            @else
                                                                Waiting
                                                            @endif
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::patient_in)
                                                            Patient In
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::patient_out)
                                                            Patient Out
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::cancel)
                                                            <span>Cancel</span>
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::no_show)
                                                            <span>No Show</span>
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::pending)
                                                            <span>Pending</span>
                                                        @elseif($val['patient_status'] == \core\enums\PatientStatus::archive)
                                                            <span>Archive</span>
                                                        @endif
                                                    </td>
                                                    @if($c_user->user_type_id == 1 || $c_user->hasAccess('supervisor.access'))
                                                        <td>
                                                            <div>
                                                                <?php
                                                                if ($val['create_by']) {
                                                                    $oneUser = Sentry::findUserById($val['create_by']);
                                                                    $groups = $oneUser->getGroups();
                                                                    $count = count($groups);
                                                                    $create_by = User::getName($val['create_by']) . ' (';
                                                                    foreach ($groups as $index2 => $val2) {
                                                                        if ($count == $index2 + 1) {
                                                                            $create_by .= $val2['name'] . ')';
                                                                        } else {
                                                                            $create_by .= $val2['name'] . ', ';
                                                                        }
                                                                    }
                                                                } else {
                                                                    $create_by = User::getName($val['create_by']);
                                                                }
                                                                ?>
                                                                {{$create_by}}
                                                            </div>
                                                        </td>
                                                        <td>{{$val['created_at']}}</td>
                                                        <td>
                                                            <div>
                                                                <?php
                                                                if ($val['update_by']) {
                                                                    $oneUser = Sentry::findUserById($val['update_by']);
                                                                    $groups = $oneUser->getGroups();
                                                                    $count = count($groups);
                                                                    $update_by = User::getName($val['update_by']) . ' (';
                                                                    foreach ($groups as $index2 => $val2) {
                                                                        if ($count == $index2 + 1) {
                                                                            $update_by .= $val2['name'] . ')';
                                                                        } else {
                                                                            $update_by .= $val2['name'] . ', ';
                                                                        }
                                                                    }
                                                                } else {
                                                                    $update_by = User::getName($val['update_by']);
                                                                }
                                                                ?>
                                                                {{$update_by}}
                                                            </div>
                                                        </td>
                                                        <td>{{$val['updated_at']}}</td>
                                                    @endif
                                                    <td>
                                                        <div style="width: 150px;cursor: pointer;" class="showPopover"
                                                             data-container="body"
                                                             data-toggle="popover" data-placement="top"
                                                             data-content="{{nl2br($val['notes'])}}">
                                                            {{$val['notes'] ? Functions::num_words($val['notes']) : ''}}...
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($val['patient_status'] == \core\enums\PatientStatus::pending
                                                    || $val['patient_status'] == \core\enums\PatientStatus::no_show
                                                    || $val['patient_status'] == \core\enums\PatientStatus::cancel
                                                    || $val['patient_status'] == \core\enums\PatientStatus::archive)
                                                            {{$val['exception_reason']}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <?php unset($reservations[$key]); ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        {{$reservations->appends(Input::except('_token'))->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="addWalkInReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add Reservation
                        <a style="margin-left: 20%" id="clearData" class="btn btn-default">Clear data</a>
                    </h4>
                </div>
                {{Form::open(array('role'=>"form", 'route' => 'addWalkInReservation'))}}
                <div class="modal-body col-md-12">

                    <div class="form-group col-md-6">
                        <label>Hospital *</label>
                        <br>
                        <select required autocomplete="off" id="selectHospital3"
                                class="form-control select2" name="hospital_id">
                            <option value="">Choose</option>
                            @foreach($hospitals as $val)
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Clinics *</label>
                        <br>
                        <select required autocomplete="off" id="selectClinic3" name="clinic_id"
                                class="form-control select2">
                            <option value="">Choose</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Physicians *</label>
                        <br>
                        <select required autocomplete="off" id="selectPhysician3" name="physician_id"
                                class="form-control select2">
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>National Id *</label>
                        <input required autocomplete="off" id="national_id" type="text"
                               name="national_id" class="form-control">
                    </div>

                    <input autocomplete="off" type="hidden" value="0" name="patient_id"
                           id="patient_id">

                    <div class="form-group col-md-6">
                        <label>Phone *</label>
                        <input required autocomplete="off" id="phone" type="text" maxlength="15"
                               name="phone" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient Id</label>
                        <input autocomplete="off" id="id" type="text"
                               name="id" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>First Name *</label>
                        <input autocomplete="off" id="first_name" type="text"
                               name="first_name" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Middle Name</label>
                        <input autocomplete="off" id="middle_name" type="text"
                               name="middle_name" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Last Name *</label>
                        <input autocomplete="off" id="last_name" type="text"
                               name="last_name" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Family Name</label>
                        <input autocomplete="off" id="family_name" type="text"
                               name="family_name" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Updated Phone</label>
                        <input autocomplete="off" id="phone2" type="text" maxlength="15"
                               name="phone2" class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>Birthday *</label>
                        <input required autocomplete="off" id="birthday" type="text"
                               data-date-format="yyyy-mm-dd" name="birthday"
                               class="form-control datepicker2">
                    </div>

                    <div class="form-group col-md-6" style="margin-bottom: 30px;">
                        <label>Gender *</label>

                        <div class="checkbox-list">
                            <label class="checkbox-inline">
                                <input required autocomplete="off" id="male" type="radio"
                                       value="2" name="gender" checked class="checkbox-inline checkbox1"> Male
                            </label>
                            <label class="checkbox-inline">
                                <input required autocomplete="off" id="female" type="radio"
                                       value="1" name="gender" class="checkbox-inline checkbox1"> Female
                            </label>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Preferred Contact *</label>
                        <br>
                        <select autocomplete="off" id="preferred_contact" style="width:100%"
                                name="preferred_contact" class="form-control select2">
                            <option value="1">Phone</option>
                            <option value="2">Email</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input autocomplete="off" id="email" type="email" name="email"
                               class="form-control">
                    </div>

                    <div class="form-group col-md-6">
                        <label>SMS Language: </label>
                        <br>
                        <select name="sms_lang" class="select2 form-control" style="width: 100%;">
                            <option selected value="1">Arabic</option>
                            <option value="2">English</option>
                        </select>
                    </div>


                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <input autocomplete="off" id="address" type="text" name="address"
                               class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Edit Reservation</h4>
                </div>
                {{Form::open(array('role'=>"form", 'route' => 'updateReservation', 'id' => 'updateReservation'))}}
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-4">
                        <label>Reservation Code</label>

                        <div id="modal_reservation_code"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Patient Id</label>

                        <div id="modal_patient_id"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Phone</label>

                        <div id="modal_phone"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>First Name</label>

                        <div id="modal_first_name"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Middle Name</label>

                        <div id="modal_middle_name"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Last Name</label>

                        <div id="modal_last_name"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Family Name</label>

                        <div id="modal_family_name"></div>
                    </div>
                    <input type="hidden" value="" name="reservation_id" id="modal_reservation_id">

                    <div class="form-group col-md-4">
                        <label>Birthday</label>

                        <div id="modal_birthday"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Gender</label>

                        <div id="modal_gender"></div>
                    </div>

                    <div class="form-group col-md-12">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Hospital</label>
                        <br>
                        <select autocomplete="off" id="selectHospital4" name="hospital_id" disabled
                                class="form-control select2" style="width: 100%">
                            <option value="">Choose</option>
                            @foreach($hospitals as $val)
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Clinics</label>
                        <br>
                        <select required autocomplete="off" id="selectClinic4" name="clinic_id" disabled
                                class="form-control select2" style="width: 100%">
                            <option value="">Choose</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Physicians</label>
                        <br>
                        <select required autocomplete="off" id="selectPhysician4" name="physician_id"
                                class="form-control select2"
                                style="width: 100%">
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Date</label>
                        <input required type="text" data-date-format="yyyy-mm-dd" id="modal_date"
                               name="date" class="form-control datepicker">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Available Time</label>
                        <select autocomplete="off" required class="form-control" name="time" id="modal_time">
                            <option value="">Choose</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCancelReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Cancel Reservation</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-12">
                        <label>Cancel Reason</label>
                        <br>
                        <select autocomplete="off" name="cancel_reason_id" id="cancel_reason_id"
                                class="form-control select2" style="width: 100%">
                            <option value="">Choose</option>
                            @foreach($cancelResReason as $val)
                                <option value="{{$val['id']}}">{{$val['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Reason Of Cancellation</label>
                        <textarea id="reservation_cancel" name="cancel_notes" class="form-control"></textarea>
                        <input type="hidden" id="modal_cancel_reservation_id" name="reservation_id">
                    </div>
                    <div class="form-group col-md-6" id="radio_sms">
                        <label>Send SMS? </label>

                        <div class="radio">
                            <label>
                                <input autocomplete="off" id="male" type="radio"
                                       value="1"
                                       name="send_sms" checked>
                                Yes
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input autocomplete="off" id="female" type="radio"
                                       value="2" name="send_sms">
                                No
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="modalCancelReservationBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="parentReservationInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Reservation Info</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-6">
                        <label>Clinic Name</label>

                        <div id="parent_clinic_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Physician Name</label>

                        <div id="parent_physician_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Code</label>

                        <div id="parent_code"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Date</label>

                        <div id="parent_reservation_date"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Time</label>

                        <div id="parent_reservation_time"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient Name</label>

                        <div id="parent_patient_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient ID</label>

                        <div id="parent_patient_id"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient Phone</label>

                        <div id="parent_patient_phone"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="revisitReservationInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Revisit Reservation Info</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-6">
                        <label>Clinic Name</label>

                        <div id="revisit2_clinic_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Physician Name</label>

                        <div id="revisit2_physician_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Code</label>

                        <div id="revisit2_code"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Date</label>

                        <div id="revisit2_reservation_date"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Time</label>

                        <div id="revisit2_reservation_time"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient Name</label>

                        <div id="revisit2_patient_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient ID</label>

                        <div id="revisit2_patient_id"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient Phone</label>

                        <div id="revisit2_patient_phone"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resendLastSmsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Resend SMS</h4>
                </div>
                {{Form::open(array('route' => 'resendLastSms'))}}
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-6">
                        <label>Reservation Code</label>

                        <div id="resend_reservation_code"></div>
                        <input type="hidden" name="reservation_id" value="" id="resend_reservation_id">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Reservation Date</label>

                        <div id="resend_reservation_date"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Patient Name</label>

                        <div id="resend_patient_name"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Patient Phone</label>

                        <div id="resend_patient_phone"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Last SMS Type</label>

                        <div id="resend_sms_type"></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label>SMS Language: </label>
                        <br>
                        <select required name="sms_lang" id="resend_sms_lang" class="select2 form-control">
                            <option value="1">Arabic</option>
                            <option value="2">English</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12" style="direction: rtl;">
                        <label>Last SMS Content</label>

                        <div id="resend_sms_content"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Resend</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCancelInfoReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Cancellation Info</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-12">
                        <label>Reason Of Cancellation</label>

                        <div id="modal_cancel_reason_id"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Cancellation Note</label>

                        <div id="modal_cancel_notes"></div>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Send SMS</label>

                        <div id="modal_send_cancel_sms"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="printResModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Print Reservation</h4>
                </div>
                <div class="modal-body col-md-12" style="text-align: center;">
                    <div class="form-group col-md-12">
                        <label>
                            <h2>
                                Print AR
                            </h2>
                        </label>
                        <div>
                            <a id="printResAr" target="_blank" class="btn btn-warning btn-lg" style=""> طباعة <i
                                        class="fa fa-print"></i></a>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="form-group col-md-12">
                        <label>
                            <h2>
                                Print EN
                            </h2>
                        </label>
                        <div>
                            <a id="printResEn" target="_blank" class="btn btn-warning btn-lg"> Print <i class="fa fa-print"></i></a>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalRevisitReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Revisit</h4>
                </div>
                {{Form::open(array('role'=>"form", 'id' => 'formRevisitReservation'))}}
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-4">
                        <label>Phone</label>

                        <div id="revisit_phone"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>First Name</label>

                        <div id="revisit_first_name"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Middle Name</label>

                        <div id="revisit_middle_name"></div>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Last Name</label>

                        <div id="revisit_last_name"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Clinic</label>

                        <div id="revisit_clinic_name"></div>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Physician *</label>
                        <select id="revisit_physician_id" required name="physician_id" class="form-control"
                                style="width:250px;">
                            <option value="">Choose</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Date Of Revisit *</label>

                        <div id="revisit_date_div">
                            <input autocomplete="off" id="revisit_date" required type="text"
                                   data-date-format="yyyy-mm-dd"
                                   name="date" class="form-control limit_datepicker">
                        </div>
                        <input type="hidden" id="revisit_reservation_id" name="reservation_id">
                        <input type="hidden" id="revisit_clinic_id" name="clinic_id">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Time *</label>
                        <select id="revisit_time" required name="time" class="form-control">
                            <option value="">Choose</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNoteReservation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Add Note To Reservation</h4>
                </div>
                <div class="modal-body col-md-12">
                    <div class="form-group col-md-12">
                        <label>Notes</label>
                        <textarea id="reservation_note" name="notes" class="form-control" rows="10" maxlength="1000"></textarea>
                        <input type="hidden" id="modal_note_reservation_id" name="reservation_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="modalNoteReservationBtn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@stop