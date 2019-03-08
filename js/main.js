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

    $(".form-note").on("submit", function(event){
        event.preventDefault();
        let add_note_field = {};
        $(".form-note__input").each(function(index, element) {
            add_note_field[$(element).attr("name")] = element.value;
        })
        add_note_field["add_note_field_list"] = $(".form-note__select").val();
        $.ajax({
            type: "POST",
            url: "scripts/add_entity.php",
            data: add_note_field,
            success: function(result){
                console.log(result);
            }
        });
    })

    $(".form-task").on("submit", function(event){
        event.preventDefault();
        let add_task_field = {};
        $(".form-task__input").each(function(index, element) {
            add_task_field[$(element).attr("name")] = element.value;
        })

        $.ajax({
            type: "POST",
            url: "scripts/add_entity.php",
            data: add_task_field,
            success: function(result){
                $('input[name="add_task_end_id"]').val(result);
            }
        });
    })
})