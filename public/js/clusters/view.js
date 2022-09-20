

    hideloading();
    $('#message_form').on('submit', function () {
        showloading();
    });
    $('.delete_content').on('click', function () {
        showloading();
    });
    function myFunction(id){
           console.log(id);
           
           $.ajax({
            type: "GET",
            url: '/cluster/addToDo/'+id,
            dataType: 'json',
            data: {},
            cache: false,
            success: function (response) {
                if(response['code'] === 200) {
                    console.log("added in to-do list");
                }else{
                    console.log("not added");
                }
            },
            error: function (request, error) {
                console.log(error);
            }
        });
    };

    $("#inviteUser").on('submit', function(e){
        e.preventDefault();
        showloading();
        $.ajax({
            type: 'post',
            url: '/cluster/inviteMail',
            dataType: 'json',
            data: $(this).serialize(),
            success: function (response) {
                if(response['Code'] === 200) {
                    console.log("Successfully mail sent!");
                    // const p = document.createElement("p");
                    // p.className = 'text-center';
                    // p.id = 'emailSuccess';
                    // p.innerText = "Mail successfully sent to the Entered Email Address!";
                    // document.getElementById('inviteUser').appendChild(p);
                }
                else{ console.log(" mail not sent!");

                   
                }
                hideloading();
            },
            error: function (request, error) {
                
            }
        });
    });


