var prod_id = '';
var prod_name = '';
var reference_num = '';
var qty = 0;
var price = 0.00;
var sub_total = 0.00;
var cur_stock = 0;
var cart_row = 1;
var grand_total_1 = 0.00;

function add_to_cart(prod_id, prod_name, cur_stock, price) {

    var prod_bg_color_class = 'label label-default';
    var qty = 1;
    var sub_total = parseInt(qty) * parseFloat(price);

    if (cur_stock <= 5) {
        prod_bg_color_class = 'label label-danger';
    } else if (cur_stock <= 10) {
        prod_bg_color_class = 'label label-warning';
    } else {
        prod_bg_color_class = 'label label-info';
    }

    var cart_row_html = '<tr id="' + cart_row + '">' +
            '<td><div class="' + prod_bg_color_class + ' prod_modal">' + prod_name.trim() + '</div></td>' +
            '<td>' + price + '</td>' +
            '<td><input type="hidden" class="form-control cart_prod_id" value="' + prod_id + '" /><input type="text" class="form-control cart_qty" value="' + qty + '" /><input type="hidden" class="form-control sell_price" value="' + price + '" /></td>' +
            '<td>' + sub_total.toFixed(2) + '</td>' +
            '<td><i class="fa fa-trash-o"></i></td>' +
            '</tr>';
    $('#cart-row').append(cart_row_html);
    $('#ref_num').val('');

    cart_row += 1;
    setTimeout(function () {
        $('#ref_num').focus();
    }, 1);
    
    $('#div_product_list').html('');
    $('#div_product_list').hide();
    calculate_sub_total(cart_row);
    return true;
}

function reset_fields() {
    $('#item_selling_price').val('');
    $('#quantity').val('');
    $('#product_details_id').val('');
    $('#product_name').val('');
    $('#ref_num').val('');
    $('#avail_stock').val('');
    $('#item_subtotal').val('');
    return true;
}

function edit_current_row(cart_div_id) {

    prod_id = $('#product_details_id' + cart_div_id).val();
    prod_name = $('#product_details_name' + cart_div_id).val();
    reference_num = $('#ref_num' + cart_div_id).val();
    qty = $('#quantity' + cart_div_id).val();
    price = $('#item_selling_price' + cart_div_id).val();
    cur_stock = $('#cur_stock' + cart_div_id).val();
    sub_total = $('#item_subtotal' + cart_div_id).val();
    $('#product_details_id').val(prod_id);
    $('#product_name').val(prod_name);
    $('#ref_num').val(reference_num);
    $('#quantity').val(qty);
    $('#item_selling_price').val(price);
    $('#avail_stock').val(cur_stock);
    $('#item_subtotal').val(sub_total);
    return true;
}

function calculate_sub_total(cart_row_id) {
    var cart_body = $('#cart-row');
    var price = parseFloat(cart_body.find('tr#' + cart_row_id + ' td:eq(2) .sell_price').val());
    var qty = parseInt(cart_body.find('tr#' + cart_row_id + ' td:eq(2) .cart_qty').val());
    var sub_total = parseFloat(qty * price).toFixed(2);
    cart_body.find('tr#' + cart_row_id + ' td:eq(3)').text(sub_total);
    calculate_grand_total();
    return true;
}

function calculate_grand_total() {

    var grand_total = 0.00;
    var grand_num_item = 0;
    var grand_qty = 0;
    
    $('#cart-row').find('tr').each(function () {
        grand_total += parseFloat($(this).find('td:eq(3)').text());
        grand_num_item += 1;
        grand_qty += parseInt($(this).find('td:eq(2) .cart_qty').val());
    });
    
    $('#cart-total tr th:eq(1)').text(grand_num_item + ' (' +grand_qty+ ')');
    $('#cart-total tr th:eq(2)').text(grand_total.toFixed(2));
    return true;
}

function calculate_balance() {
    var paid = 0.00;
    var balance = 0.00;
    grand_total = parseFloat($('#ProductStockSales_grand_total_payable').val());
    paid = parseFloat($('#ProductStockSales_grand_total_paid').val());

    balance = grand_total - paid;

    balance = paid - grand_total;

    if (paid > grand_total) {
        $('#balance_lable').text('Return');
    } else {
        $('#balance_lable').text('Due');
    }

    balance = Math.abs(balance);
    balance = balance.toFixed(2);
    $('#ProductStockSales_grand_total_balance').val(balance);
    return true;
}

$(document).ready(function () {

    $('body').addClass('sidebar-collapse');
    $(document).on('keypress', function (e) {

        if (e.keyCode == 13) {
            return false;
        }
    });

    $(document).off('click', '.prod_modal').on('click', '.prod_modal', function () {
        var price = parseFloat($(this).parent('td').parent('tr').find('.sell_price').val());
        var cart_row_id = $(this).parent('td').parent('tr').attr('id');
        $('#cart_row_id_container').val(cart_row_id);

        $('#price').val(price.toFixed(2));
        $('#myModal').modal();
    });

    $(document).on('keypress', function (e) {
        if (e.keyCode == 13) {
            if ($('#myModal').hasClass('in')) {
                var cart_row_id = $('#cart_row_id_container').val();
                var price = $('#price').val();
                var cart_body = $('#cart-row');
                cart_body.find('tr#' + cart_row_id + ' td:eq(1)').text(parseFloat(price).toFixed(2));
                cart_body.find('tr#' + cart_row_id + ' td:eq(2) .sell_price').val(parseFloat(price).toFixed(2));

                calculate_sub_total(cart_row_id);
                
                $('.modal-header button.close').click();
                
            }
        }
    });

    $('#myModal').on('hide.bs.modal', function (e) {
        var cart_row_id = $('#cart_row_id_container').val();
        var price = $('#price').val();
        var cart_body = $('#cart-row');
        cart_body.find('tr#' + cart_row_id + ' td:eq(1)').text(parseFloat(price).toFixed(2));
        cart_body.find('tr#' + cart_row_id + ' td:eq(2) .sell_price').val(parseFloat(price).toFixed(2));

        calculate_sub_total(cart_row_id);
    });

    $(document).off('keyup', '.cart_qty').on('keyup', '.cart_qty', function (e) {
        var er = /^-?[0-9]+$/;
        var qty = $(this).val();

        if (er.test(qty)) {
            var cart_row_id = $(this).parent('td').parent('tr').attr('id');
            calculate_sub_total(cart_row_id);
        } else {
            alert('Number only.');
            $(this).val(1);
        }

    });

    $(document).off('click', 'i.fa-trash-o').on('click', 'i.fa-trash-o', function () {
        $(this).parent('td').parent('tr').remove();
    });

    $(document).off('blur', '#ref_num').on('blur', '#ref_num', function () {
        var ref_num = $(this).val();
        if (ref_num == '') {
            return false;
        }

        $.ajax({
            url: 'product_stock_info',
            type: 'post',
            dataType: "json",
            data: {ref_num: ref_num},
            success: function (data) {
                var prod_list = '';
                if ((data.response != undefined)) {
                    if ((data.response.length) > 1) {
                        $.each(data.response, function (k, v) {
                            prod_list += '<div class="radio-inline">' +
                                    '<label>' +
                                    '<input class="prod-list-radio" id="prod_' + v.product_id + '" type="radio" value="' + v.product_id + '" name="product_list" />' + v.product_name +
                                    '<input type="hidden" id="prod_price_' + v.product_id + '" value="' + v.price + '" >' +
                                    '<input type="hidden" id="prod_cur_stock_' + v.product_id + '" value="' + v.cur_stock + '" >' +
                                    '</label>' +
                                    '</div>';
                        });
                        $('#div_product_list').html('');
                        $('#div_product_list').html(prod_list);
                        $('#div_product_list').show();
                    } else {

                        if (data.response[0].cur_stock <= 0) {
                            alert('Product: --' + data.response[0].product_name + '-- is out of stock.');
                            return false;
                        }
                        add_to_cart(
                                data.response[0].product_id,
                                data.response[0].product_name,
                                data.response[0].cur_stock,
                                data.response[0].price
                                );
                        $('#div_product_list').html('');
                        $('#div_product_list').hide();
                    }
                }

            },
            error: function () {

            }
        });
    });

    $(document).on('click', '.prod-list-radio', function () {
        var ref_num = $('#ref_num').val();
        var prod_id = $(this).val();
        $.ajax({
            url: 'product_stock_info',
            type: 'post',
            dataType: "json",
            data: {prod_id: prod_id, ref_num: ref_num},
            success: function (data) {

                if (data.response[0].cur_stock <= 0) {
                    alert('Product: --' + data.response[0].product_name + '-- is out of stock.');
                    return false;
                }
                add_to_cart(
                        data.response[0].product_id,
                        data.response[0].product_name,
                        data.response[0].cur_stock,
                        data.response[0].price
                        );
            },
            error: function () {

            }
        });
    });

    /** TILL THIS FIXED **/

    $(document).off('change', '.qty').on('change', '.qty', function () {
        var cur_qty = parseInt($(this).val());
        var sell_price = parseInt($(this).siblings('.sell_price').val());
        $(this).parent('td').parent('tr td:nth-child(3)').text(sell_price + cur_qty);
    });

    grand_total_1 = $('#ProductStockSales_grand_total_payable').val();
    var dis_cnt = $('#ProductStockSales_dis_amount').val();
    if (dis_cnt != '' && dis_cnt > 0) {
        var grand_total_2 = 0.00;
        $('#cart-row').find('input[class="sub_total"]').each(function () {
            grand_total_2 += parseFloat($(this).val());
        });
        grand_total_1 = grand_total_2;
    }

    $('#product-stock-entries-form').submit(function () {
        if ($('#product_details_id').length <= 0 || $('#ProductStockSales_grand_total_paid').val() == '' || parseInt($('#ProductStockSales_grand_total_paid').val()) <= 0) {
            return false;
        }
    });



    //        $('#quantity').blur(function() {
    $('#item_selling_price').blur(function () {

        var qty = parseInt($('#quantity').val());
        //            var qty = parseInt($(this).val());
        var cur_stock = parseInt($('#avail_stock').val());
        if (qty > cur_stock) {
            alert('Quantity is more than available stock.');
            setTimeout(function () {
                $('#quantity').focus();
            }, 1);
            return false;
        }

        if (add_to_cart() === true) {
            if (reset_fields()) {
                calculate_grand_total();
                calculate_balance();
            }
        }

    });

    $(document).on('click', '.delete-button', function () {
        var row_num = $(this).attr('data');
        $("div[id=" + row_num + "]").remove();
        calculate_grand_total();
    });



    $(document).on('click', '.edit-button', function () {
        var row_num = $(this).attr('data');
        if (edit_current_row(row_num)) {
            $("div[id=" + row_num + "]").remove();
        }
        calculate_grand_total();
    });

    $(document).on('keyup', '#ProductStockSales_grand_total_paid', function () {
        calculate_balance();
    });

    $(document).on('keyup', '#ProductStockSales_dis_amount', function () {

        if ($(this).val() == '') {
            $('#ProductStockSales_grand_total_payable').val(grand_total_1);
        } else {
            var dis_amnt = parseFloat($(this).val());
            var total_payable = grand_total_1 - dis_amnt;
            $('#ProductStockSales_grand_total_payable').val(total_payable.toFixed(2));

            calculate_balance();

        }

    });
});