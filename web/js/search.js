$(document).ready(function () {
    $('#searchButton').on('click', function () {
        var text = $('#searchText').val();
        if(text == ''){
            return false;
        };
        $.ajax({
            url: "/task/search",
            type: "post",
            data: "search=" + text,
            success: function(data){
                $('tbody.mainTable').html(data);
                init();
            },
        });
    });
});