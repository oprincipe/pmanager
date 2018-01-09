$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
    });


    if($("#errors-alert")) {
        $("#errors-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#errors-alert").slideUp();
        });
    }

});

function hideDisplayMessage(_type)
{
    setTimeout('$("#userMessage div.alert-'+_type+'").hide("slow")', 2000);
}

function displayErrorMessage(_msg) {
    $("#userMessage div.alert-danger").html(_msg).show();
    hideDisplayMessage('danger');
}

function displayInfoMessage(_msg) {
    $("#userMessage div.alert-info").html(_msg).show();
    hideDisplayMessage('info');
}

function displayWarningMessage(_msg) {
    $("#userMessage div.alert-warning").html(_msg).show();
    hideDisplayMessage('warning');
}

function displaySuccessMessage(_msg) {
    $("#userMessage div.alert-success").html(_msg).show();
    hideDisplayMessage('success');
}
