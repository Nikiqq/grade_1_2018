$(function(){

    function prepare_data(className) {
        let arrayData = {};
        className.find(".form__input, .form__select").each(function(index, element) {
            arrayData[$(element).attr("name")] = element.value;
        });
        return arrayData;
    }

    function ajaxQuery(data, elem) {
        $.ajax({
            type: "POST",
            url: "scripts/add_entity.php",
            data: data,
            success: function(result){
                if(elem) {
                    elem.val(result);
                }
                else {
                    console.log(result);
                }
            }
        });
    }

    $(".form").on("submit", function(event){
        event.preventDefault();
        let data = prepare_data($(this)),
            elem = false;
        if($(this).hasClass("form-task")) {
            elem = $('input[name="task_end_id"]');
        }
        ajaxQuery(data, elem);
    });
});