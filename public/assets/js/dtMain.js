(function($) {
    "use strict";

    $(document).ready(function() {

        let ticketType = $('#ticketType').data('type');
        let startDate, endDate,ticketDepartment,ticketPriority,ticketOptType, ticketOptType2;

        let datatableSubmit = $('#data_table').DataTable({
            language: {
                searchPlaceholder: "Input Ticket ID or Title"
            },
            order: [ [0, 'desc'] ],
            "processing": true,
            "serverSide": true,
            "fixedHeader": {
                "headerOffset": $('.main-header').outerHeight()
            },
            "ajax": {
                url: window.appUrl+"/get-ticket-data",
                data: function (d) {
                    d.startDate = startDate;
                    d.endDate = endDate;
                    d.ticketDepartment = ticketDepartment;
                    d.ticketType = ticketType;
                    d.ticketPriority = ticketPriority;
                    d.ticketOptType = ticketOptType;
                    d.ticketOptType2 = ticketOptType2;
                }
            },
            "columns":[
                { data: "department", name: "department_id" },
                { "data": "ticket_id" },
                { data: "ticket_title", name: "title" },
                { data: "priority", name: "priority" },
                { data: "value", name: "value" },
                { data: "user_name", name: "user_id" },
                { data: "ticket_status", name: "status" },
                { data: "jira", name: "jira"},
                { data: "updated", name: "updated_at" },
                { data: 'action', name: 'action', orderable: false, searchable: false},

            ]
        });

        //filter
        $(function() {

            var start = moment().subtract(29, 'days');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                datatableSubmit.draw();
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            //cb(start, end);

        });

        $(document).on('change','#ticketDepartment', function () {
            ticketDepartment = $('#ticketDepartment').val();
            datatableSubmit.draw();
        });
        $(document).on('change','#ticketPriority', function () {
            ticketPriority = $('#ticketPriority').val();
            datatableSubmit.draw();
        });
        $(document).on('change','#ticketOptType', function () {
            ticketOptType = $('#ticketOptType').val();
            datatableSubmit.draw();
        });
        $(document).on('change','#ticketTypes2', function () {
            ticketOptType2 = $('#ticketTypes2').val();
            datatableSubmit.draw();
        });
        //modal assign department
        // Get single ticket department in EditModel
        $('.modelClose').on('click', function(){
            $('#TicketAssignedDepartmentModal').hide();
        });
        var id;
        $('body').on('click', '#getAssignedTicketData', function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: window.appUrl+"/ticket-assign-to/"+id,
                method: 'GET',
                success: function(result) {
                    $('.page-loader').addClass('d-none');
                    $('#AssignedTicketModalBody').html(result.html);
                    $('#TicketAssignedDepartmentModal').show();
                }
            });
        });

        // Update department Ajax request.
        $('#SubmitTicketAssignedForm').click(function(e) {
            e.preventDefault();
            $('.page-loader').removeClass('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: window.appUrl+"/ticket-assigned/"+id,
                method: 'post',
                data: {
                    department: $('#assignedDepartment').val(),
                },
                success: function(result) {
                    $('.page-loader').addClass('d-none');
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('#data_table').DataTable().ajax.reload();
                        setInterval(function(){
                            $('.alert-success').hide();
                            $('#TicketAssignedDepartmentModal').hide();
                        }, 2000);
                    }
                }
            });
        });

        // open modal JIRA
        $('body').on('click', '#getJiraData', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let jira = $(this).data('jira');
            $('#getJiraModal').show();
            $("#txtidticket").val(id)
            $("#jira").val(jira);
            $("#jira").text(jira);
        });

        // open modal btn Close
        $('body').on('click', '#btnCloseTicket', function(e) {
            e.preventDefault();
            let ticket = $(this).data('ticket');
            $("#txtTicketClose").val(ticket);
            $("#txtNumTicket").html(ticket);
            $('#btnCloseModal').show();
        });

        // Clear URL in the input 
        $("#jira").click(function(){
            $(this).val("");
        })

        // Create URL in based id JIRA
        $("#jira").blur(function(){
           let id = $(this).val();
           if (id !== "") {
               $(this).val("https://implementhit.atlassian.net/browse/"+id);
           }
        });

        $('.btnclosejira').on('click', function(){
            $('#getJiraModal').hide();
            $("#alertjirasuccess").hide();
            $("#alertjiraerror").hide();
        });

        $('.closeModalTicket').on('click', function(){
            $('#btnCloseModal').hide();
        });

        $('#btnUpdateJira').click(function (){
            let id = $("#txtidticket").val();
            let url = window.appUrl+"/update-ticket-jira/"+id
            let jira = $("#jira").val();
            if (jira !== "") {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(url, {"jira": jira}, function(value) {
                    $("#alertjiraerror").hide();
                    $("#jira").val("");
                    $("#alertjirasuccess").show();
                    $('#data_table').DataTable().ajax.reload();
                });
            } else {
                $("#alertjiraerror").show();
            }
        });

        $('#btnSureClose').click(function (){
            let id = $("#txtTicketClose").val();
            let url = window.appUrl+"/close_ticket/"+id
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post(url, function(value) {
                $('#btnCloseModal').hide();
                $('#data_table').DataTable().ajax.reload();
            });
        })
    });

})(jQuery);