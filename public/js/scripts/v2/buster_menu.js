$(document).ready(function() {

    // old
    
    var mQuantity = 0;
    var fQuantity = 0;

    $('#mQuantityMinus').click(function() {
        mQuantity = $(this).Quantity({
            operation:'minus',
            targetDOM:$('.male_quantity strong'),
            item_quantity:mQuantity
        });
    });

    $('#mQuantityAdd').click(function() {
        mQuantity = $(this).Quantity({
            operation:'add',
            targetDOM:$('.male_quantity strong'),
            item_quantity:mQuantity
        });
    });

    $('#fQuantityMinus').click(function() {
        fQuantity = $(this).Quantity({
            operation:'minus',
            targetDOM:$('.female_quantity strong'),
            item_quantity:fQuantity
        });
    });

    $('#fQuantityAdd').click(function() {
        fQuantity = $(this).Quantity({
            operation:'add',
            targetDOM:$('.female_quantity strong'),
            item_quantity:fQuantity
        });
    });

    $('#itemDetail').on('hidden.bs.modal', function(e) {
        $('.male_quantity strong').html('00');
        $('.female_quantity strong').html('00');
        mQuantity = 0;
        fQuantity = 0;
    });
    
});