jQuery(document).ready(function($){
    //open popup
    $('.cd-popup-trigger').on('click', function(event){
        event.preventDefault();
        $('.cd-popup').addClass('is-visible');
        console.log( "popup load" );
    });

    //close popup
    $('.cd-popup').on('click', function(event){
        if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
            event.preventDefault();
            $(this).removeClass('is-visible');
        }

        if( $(event.target).is('.cd-popup-cancel') || $(event.target).is('.cd-popup') ) {
            event.preventDefault();
            $(this).removeClass('is-visible');
        }
    });
    //close popup when clicking the esc keyboard button
    $(document).keyup(function(event){
        if(event.which=='27'){
            $('.cd-popup').removeClass('is-visible');
        }
    });
});

function load(page,div){
    jQuery.ajax({
        url: page,
        beforeSend: function(){
            loader();
        },
        success: function(response){
            jQuery(div).html(response);
            close();
        },
        dataType:"html"
    });
    return false;
}

function loader(){
    $.facebox('<div style="padding: 17px; font-size: 14px;">Proses....</div>');
}

function close(){
    $.facebox.close();
}

function set_value(id){
    $("#deleted").val(id);
}

function delete_item(link){
    id = $("#deleted").val();

    if (id != "") {
        $.ajax({
            url: link+'/delete/'+id,
            beforeSend: function(){
                loader();
            },
            success: function(response){
                $('.cd-popup').removeClass('is-visible');
                close();

                load(link+'/list_data', '#result');
            },
            type:"get",
            dataType:"html"
        });
    }
}