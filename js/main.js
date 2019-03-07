$(function(){
    $(".form-entity").on("submit", function(event){
        event.preventDefault();
        let numbers = {};
        $(".form-entity__input").each(function(index, element) {
            numbers[$(element).attr("name")] = element.value;
        })
        $.ajax({
            type: "POST",
            url: "scripts/add_entity.php",
            data: numbers,
            success: function(result){
                console.log(result);
            }
        });
    })

    $(".form-text").on("submit", function(event){
        event.preventDefault();
        let numbers_text_field = {};
        $(".form-text__input").each(function(index, element) {
            numbers_text_field[$(element).attr("name")] = element.value;
        })
        $.ajax({
            type: "POST",
            url: "scripts/add_entity.php",
            data: numbers_text_field,
            success: function(result){
                console.log(result);
            }
        });
    })
})