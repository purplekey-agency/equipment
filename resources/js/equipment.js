$(document).ready(function(){

    $('#type').on('change', function(){
        if(this.value == 0){
            $('#equipment_name_container').removeClass('hidden');
            $('#equipment_name').prop('required', true);
        }
        else{
            $('#equipment_name_container').addClass('hidden');
            $('#equipment_name').prop('required', false);
        }
    });

    $('#rentable').on('change', function(){
        if(this.value == 0){
            $('#nonrentabile_user_container').removeClass('hidden');
            $('#nonrentabile_user').prop('required', true);
        }
        else{
            $('#nonrentabile_user_container').addClass('hidden');
            $('#nonrentabile_user').prop('required', false);
        }
    });


})

