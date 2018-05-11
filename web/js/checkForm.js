$('button.sub').on("click", function(e){
    var val = $("#taskName").val();
    if(val == ''){
        $("#nameHelpBlock").text('Enter Name Task');
        return false;
    };
});