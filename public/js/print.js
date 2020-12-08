function printLabel(id){
    
    $('#print_label_equipment_id').val(id);
    $('#print_label_submit_btn').click();

}

function deleteEquipment(id){

    var r = confirm("This will delete equipment from system. Are you sure?");

    if(r == true){
        $('#delete_equipment_id').val(id);
        $('#delete_submit_btn').click();
    }

}

function printBulkLabel(){
    $('#print_bulk_label_submit_btn').click();
}