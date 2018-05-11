function init(){
    $(document).ready(
        function () {
            $('button.deleteTask').each(function () {
                    $(this).on('click', function () {

                        var uuid = $(this).attr('uuid');
                        $.ajax({
                            url: "/task/delete/" + uuid,
                            type: "get",
                            success: function(data){
                                $('tbody.mainTable').html(data);
                                init();
                            },
                        });

                    });
                }
            );
        }
    );
};
init();