$(document).ready(function () {
    $('#searchButton').on('click', function () {
        var text = $('#searchText').val();
        if(text == ''){
            return false;
        };
        $.ajax({
            url: "/task/search/" + text,
            type: "post",
            success: function(data){
                $('tbody.mainTable').html(data);
            },
        });
    });
});