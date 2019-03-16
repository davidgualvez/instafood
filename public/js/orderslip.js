$(document).ready( function() {
    cl(['orderslipJS']);
});

function setOrderSlip(obj = null){

    if( obj == null){
        obj = {
            order_slip_id : null,
            items: [],
            others: []
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

function updateOrderSlip(obj){
    setStorage('order_slip', JSON.stringify(obj));
}

function selectedItemFormatter(item){
    //cl(['item: ',item]);
    // level 1
    var _item = {
        id          : item.item.product_id,
        name        : item.item.description,
        price       : item.item.srp,
        qty         : item.ordered_qty,
        instruction : item.instruction,
        is_food     : item.item.is_food,
        is_postmix  : item.item.is_postmix,
        parts_type  : item.item.parts_type,
        order_type  : item.order_type,
        components  : []
    };

    // level 2
    var components  = item.components;
    cl(['components length: ',components.length])
    if (components.length > 0){
        var __item = [];
        for(var i = 0 ; i < components.length; i++){
            __item.push( components[i].item);
        }
        _item.components.push(__item);
    }

    return _item;
}