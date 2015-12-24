$(document).ready(function () {

    $(document).off('click', '.close-modal-item-barcode-view').on('click', '.close-modal-item-barcode-view', function (e) {
        $('#itemModalView').modal('hide');
    });
    
    $(document).off('click', '.datagrid .fa-barcode').on('click', '.datagrid .fa-barcode', function (e) {
        e.preventDefault();

        var row = $(this).closest('tr');
        var product_details_id = row.find('div.datagrid-cell-c1-id').text();
        var current_stock = row.find('div.datagrid-cell-c1-quantity').text();
        var num_barcode = parseInt(current_stock) + 2;

        $('#num_barcode').val('');
        $('#num_barcode').val(num_barcode);

        if ($('#itemModal #product_details_id').length == 0) {
            $('#itemModal').append('<input type="hidden" name="product_details_id" id="product_details_id" value="' + product_details_id + '" />');
        } else {
            $('#itemModal #product_details_id').val(product_details_id);
        }

        $('#itemModal').modal();

    });

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
            dataType: 'html',
            data: {
                product_details_id: $('#product_details_id').val(),
                num_barcode: num_barcode
            },
        }).done(function (data) {

            $('.barcode-container').html('');
            $('.barcode-container').html(data);
            $('.barcode-wrapper').show('slow');

            if ($('.barcode-content-for-modal').length > 0) {

                var pdf_download_url = '/product/manage/downloadBarcode?barcode=';
                var hash = CryptoJS.MD5($('#product_details_id').val());

                $('.barcode-content-for-modal').find('a').attr('href', pdf_download_url + hash + '_barcodes.pdf');
                $('#itemModalView .modal-body').html($('.barcode-content-for-modal').html());
                $('#itemModalView').modal();
            }

        }).fail(function (e) {
            console.log(e);
        });

    });

});