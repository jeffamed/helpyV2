(function($) {
    "use strict";

    $(document).ready(function () {

        let url = window.location.href;
        let path = window.location.pathname;

        //sidebar menu active inactive
        if (url.includes('dashboard')){
            $("#dashboard").addClass("active");
        }
        else if (url.includes('tickets')){
            let element = document.getElementById("tickets");
            element.classList.remove("active");

            $("#tickets a").attr("aria-expanded","true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            //$(".alltickets").addClass("active");
            $("#ticketsID").addClass("active");
        }
        else if (url.includes('closed-tickets')){
            let element = document.getElementById("tickets");
            element.classList.remove("active");

            $("#tickets a").attr("aria-expanded","true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            $(".closed-tickets").addClass("active");
            $("#ticketsID").addClass("active");
        }
        else if (url.includes('open-tickets')){
            let element = document.getElementById("tickets");
            element.classList.remove("active");

            $("#tickets a").attr("aria-expanded","true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            $(".opened-tickets").addClass("active");
            $("#ticketsID").addClass("active");
        }
        else if(url.includes('ticket')){
            $("#tickets a").attr("aria-expanded","true");
            $("#tickets a").addClass("collapsed");
            $("#submenuTickets").addClass("show");
            $("#ticketsID").addClass("active");

            // Summernote
            //$('.textarea').summernote();
        }
        else if(url.includes('departments')){
            $("#department").addClass("active");
        }
        else if(url.includes('department')){
            $("#department").addClass("active");
        }
        else if(url.includes('knowledge-base') || url.includes('knowledge-base-edit')){
            $("#kb").addClass("active");
            let id = $('#editKB').data('id');
                //console.log(url)
                //console.log(url)
            if (url == appUrl+'/knowledge-base-edit/'+id){
                //$('.textarea').summernote();
            }
            if (url == appUrl+'/knowledge-base-create'){
                //$('.textarea').summernote();
            }
        }
        else if(url.includes('staffs') || url.includes('staff')){
            $("#staff").addClass("active");
        }
        else if(url.includes('roles') || url.includes('role')){
            $("#roles").addClass("active");
        }
        else if(url.includes('app-settings')){
            $(".nav-item a").attr("aria-expanded","true");
            $(".nav-item a").addClass("collapsed");
            $("#submenuSetting").addClass("show");
            $("#submenuSetting li:nth-child(1)").addClass("active");
            $("#appSettings").addClass("active");
        }
        else if(url.includes('email-settings')){
            $(".nav-item a").attr("aria-expanded","true");
            $(".nav-item a").addClass("collapsed");
            $("#submenuSetting").addClass("show");
            $("#submenuSetting li:nth-child(2)").addClass("active");
            $("#appSettings").addClass("active");
        }
        else if (url.includes('email-template')){
            $(".nav-item #settings a").attr("aria-expanded","true");
            $(".nav-item #settings a").addClass("collapsed");
            $("#submenuSetting").addClass("show");
            $("#submenuSetting li:nth-child(3)").addClass("active");
            $("#appSettings").addClass("active");
            let eID = $('#eTemp').data('id');
            if (url == appUrl+'/email-template/'+eID+'/edit'){
                //$('.textarea').summernote();
            }
        }
        else if (url.includes('aboutus')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(8)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('counter')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(6)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if(url.includes('footer-setting')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(9)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('header-text')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(3)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('how-we-work')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(4)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('logo-icon')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(1)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if(url.includes('service')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(5)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('social-link')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(2)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('testimonial')){
            $(".nav-item #frontend a").attr("aria-expanded","true");
            $(".nav-item #frontend a").addClass("collapsed");
            $("#submenuFrontend").addClass("show");
            $("#frontend li:nth-child(7)").addClass("active");
            $("#webSetting").addClass("active");
        }
        else if (url.includes('inbox') || url.includes('read-messgae')){
            $("#inbox").addClass("active");
        }

        else if (url.includes('users')){
            $("#users").addClass("active");
        }





        //knowledge base article pin unpin
        $(document).on("change", '.pinned-class', function(e){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            //var status = $(this).prop('checked') == true ? 1 : 0;
            let id = $(this).data('id');

            $.ajax({
                type: "get",
                dataType: "json",
                url: window.appUrl+'/knowledge-pinned/'+id,
                success: function(data){
                    toastr.success('Knowledge base pinned updated')

                },
                error: function(data){
                    toastr.error('Knowledge base update failed!')
                }
            });
        })

        //email setting
        $('select#emailDriver').trigger('change');

        $(document).on('change','#emailDriver', function(){
            let driver = $(this).val();
            if (driver == 'sendmail' || driver == 'mandrill' || driver == 'mailgun' || driver == 'sparkpost' || driver == 'ses' || driver == 'postmark') {
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword").hide('slow');
            }else{
                $("#smtpHost,#encryption,#smtpPort,#smtpUsername,#smtpPassword").show('slow');
            }
        });

    });


})(jQuery);