$(document).ready( function() {
    cl(['orderslipJS']);
});

function setOrderSlip(obj = null){

    if( obj == null){
        obj = {
            order_slip_id : null,
            items: null,
            others: null
        }; 
    }  

    setStorage('order_slip', JSON.stringify(obj)); 
    return obj;
}

function getOrderSlip(){
    var os_string   = getStorage('order_slip'); 

    if (os_string == 'null' || os_string == ''){
        return false;
    } 

    var os_object   = JSON.parse(os_string); 
    return os_object;
}

function selectedItemFormatter(item){

    // level 1
    var item = {
        id          : item.item.product_id,
        name        : item.item.description,
        price       : item.item.srp,
        qty         : item.ordered_qty,
        instruction : item.instruction,
        is_food     : item.item.is_food,
        is_postmix  : item.item.is_postmix,
        parts_type  : item.item.parts_type
    };


    return item;
}