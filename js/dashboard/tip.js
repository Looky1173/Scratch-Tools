$(document).ready(function(){
    $.ajax({
        type: "POST",
        url: "/resources/ajax/dashboard/fetch-tip.php",
        dataType: "json",
        success: function(data){
            console.log(data);
            $('#tip-placeholder').replaceWith(data.tip);
        },
        error: function(){
            $('#tip-placeholder').replaceWith('<b>Failed to get tip!</b>');
        }
    })
})