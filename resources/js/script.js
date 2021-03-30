$(document).ready(function(){

    $('#submit').click( function() {

        if ($('#url').val() === ''){
            alert('It seems that someone forgot to indicate the original link');
        } else {
            $.ajax({
                type: 'POST',
                url:'/ajax',
                data: { url: $('#url').val() },
                success:function(data) {
                    let parse = JSON.parse(data);
                    $('#short_block').removeAttr('hidden');
                    $('#short_link').val(parse.link);
                }
            });
        }
    });
});

function copyUrl() {
    let input = $('#short_link');
    input.select();
    document.execCommand("copy");
}