$(function(){
    $(".form").on("submit", function(event){
        event.preventDefault();
        let numbers = {};
        $(".form__input").each(function(index, element) {
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
})