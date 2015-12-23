$(document).ready(function () {

    $(document).off('click', '#gen-barcode').on('click', '#gen-barcode', function () {
        $('#num_barcode').val('');
        $('#num_barcode').val(parseInt($('#current_stock').val()) + 2);
        $('#itemModal').modal();
    });

    $(document).off('click', '#btn_get_barcode').on('click', '#btn_get_barcode', function () {
        var num_barcode = $('#num_barcode').val();

        $.ajax({
            url: '/product/manage/itembarcode',
            type: 'post',
            dataType: 'json',
            data: {
                product_details_id: $('#product_details_id').val(),
                num_barcode: num_barcode
            },
        }).done(function (data) {
            console.log(data);
        }).fail(function (e) {

        });

//        alert(num_barcode);
        return false;

    });

});