var cart_row = 0;
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
            '<td>' +
                '<input type="hidden" class="form-control cart_prod_id" value="' + prod_id + '" />' +
                '<input type="text" class="form-control cart_qty" value="' + qty + '" />' +
                '<input type="hidden" class="form-control sell_price" value="' + price + '" />' +
            '</td>' +
            '<td>' + sub_total.toFixed(2) + '</td>' +
            '<td><i class="fa fa-trash-o"></i></td>' +
            '</tr>';
    $('#cart-row').append(cart_row_html);
    $('#ref_num').val('');

    setTimeout(function () {
        $('#ref_num').focus();
    }, 1);

    $('#div_product_list').html('');
    $('#div_product_list').hide();
    calculate_sub_total(cart_row);
    cart_row += 1;
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

var cart_rows = {};
function calculate_sub_total(cart_row_id) {

    var cart_body = $('#cart-row');
    var item_id = parseFloat(cart_body.find('tr#' + cart_row_id + ' td:eq(2) .cart_prod_id').val());
    var qty = parseInt(cart_body.find('tr#' + cart_row_id + ' td:eq(2) .cart_qty').val());
    var price = parseFloat(cart_body.find('tr#' + cart_row_id + ' td:eq(2) .sell_price').val());
    var sub_total = parseFloat(qty * price);

    cart_body.find('tr#' + cart_row_id + ' td:eq(3)').text(sub_total.toFixed(2));

    var cart_item = {
        item_id: item_id,
        qty: qty,
        price: price,
        sub_total: sub_total,
    };
    cart_rows = cart_item;
    
    calculate_grand_total();
    return true;
}

function add_cart_items() {
    var post_data = cart_rows;
    var cart_id = $('#cart_id').val();

    if (cart_id > 0) {
        $.ajax({
            url: '/cart/add_items',
            type: 'post',
            dataType: 'json',
            data: {cart_id: cart_id, post_data: post_data},
        }).done(function (data) {
            
            console.log(data);
            

        }).fail(function (e) {

        });
    }
}

function calculate_grand_total() {

    var grand_total = 0.00;
    var grand_num_item = 0;
    var grand_qty = 0;
    var cart_id = $('#cart_id').val();
    var discount = 0;
    var post_data = {};

    $('#cart-row').find('tr').each(function () {
        grand_total += parseFloat($(this).find('td:eq(3)').text());
        grand_num_item += 1;
        grand_qty += parseInt($(this).find('td:eq(2) .cart_qty').val());
    });

    $('#cart-total tr th:eq(1)').text(grand_num_item + ' (' + grand_qty + ')');
    $('#cart-total tr th:eq(2)').text(grand_total.toFixed(2));

    var url_action = (cart_id > 0) ? 'edit' : 'add';

    post_data['cart_id'] = cart_id;
    post_data['grand_total'] = grand_total;
    post_data['discount'] = discount;
    post_data['type'] = 'sale';

    $.ajax({
        url: '/cart/' + url_action,
        type: 'post',
        dataType: 'json',
        data: post_data,
    }).done(function (data) {
        cart_id = data.cart_id;
        $('#cart_id').val(cart_id);
        add_cart_items();

//        $.ajax({
//            url: '/cart/' + url_action,
//            type: 'post',
//            dataType: 'json',
//            data: post_data,
//        }).done(function (data) {
//            cart_id = data.cart_id;
//            $('#cart_id').val(cart_id);
//        }).fail(function (e) {
//
//        });

    }).fail(function (e) {

    });
    return cart_id;
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
//    var retrievedObject = localStorage.getItem('cart-'+42);
//console.log( JSON.parse(retrievedObject));
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

});