var cart_row = 1;
function add_to_cart(prod_id, prod_name, cur_stock, price, vat, discount, reference_number) {

    var prod_bg_color_class = 'label label-default';
    var cart_row_html = '';
    var row_exists_id = check_exists(prod_name, prod_id);

    if (row_exists_id == 0) {

        var qty = 1;
        var sub_total = parseInt(qty) * parseFloat(price);

        if (cur_stock <= 5) {
            prod_bg_color_class = 'label label-danger';
        } else if (cur_stock <= 10) {
            prod_bg_color_class = 'label label-warning';
        } else {
            prod_bg_color_class = 'label label-success';
        }

        cart_row_html = '<tr id="' + cart_row + '">' +
                '<td><div class="' + prod_bg_color_class + ' prod_modal">' + prod_name.trim() + '</div></td>' +
                '<td>' + price + '</td>' +
                '<td>' +
                '<input type="hidden" class="form-control cart_prod_id" value="' + prod_id + '" />' +
                '<input type="text" class="form-control cart_qty" value="' + qty + '" />' +
                '<label style="display: none;" class="cart_qty_lbl">' + qty + '</label>' +
                '<input type="hidden" class="form-control sell_price" value="' + price + '" />' +
                '<input type="hidden" class="form-control cart_cur_stock" value="' + cur_stock + '" />' +
                '<input type="hidden" class="form-control cart_vat" value="' + vat + '" >' +
                '<input type="hidden" class="form-control cart_discount" value="' + discount + '" >' +
                '<input type="hidden" class="form-control cart_reference_number" value="' + reference_number + '" >' +
                '</td>' +
                '<td>' + sub_total.toFixed(2) + '</td>' +
                '<td><i class="fa fa-trash-o"></i></td>' +
                '</tr>';
        $('#cart-row').append(cart_row_html);
        calculate_sub_total(cart_row);
        cart_row += 1;
    } else {
        calculate_sub_total(row_exists_id);
    }

    $('#ref_num').val('');

    setTimeout(function () {
        $('#ref_num').focus();
    }, 1);

    $('#div_product_list').html('');
    $('#div_product_list').hide();

    return true;
}

var cart_rows = {};
function calculate_sub_total(cart_row_id) {

    var cart_body = $('#cart-row');
    var item_id = parseInt(cart_body.find('tr#' + cart_row_id + ' td .cart_prod_id').val());
    var qty = parseInt(cart_body.find('tr#' + cart_row_id + ' td .cart_qty').val());
    var price = parseFloat(cart_body.find('tr#' + cart_row_id + ' td .sell_price').val());
    var sub_total = parseFloat(qty * price);
    var reference_number = parseInt(cart_body.find('tr#' + cart_row_id + ' td .cart_reference_number').val());

    cart_body.find('tr#' + cart_row_id + ' td:eq(2) .cart_qty_lbl').text(qty);
    cart_body.find('tr#' + cart_row_id + ' td:eq(3)').text(sub_total.toFixed(2));

    var cart_item = {
        item_id: item_id,
        qty: qty,
        price: price,
        sub_total: sub_total,
        reference_number: reference_number,
    };
    cart_rows = cart_item;

    calculate_grand_total();
    return true;
}

function check_exists(prod_name, prod_id) {

    var cart_tr_id = 0;
    var cart_rows = $('#cart-row').find('tr');

    if (cart_rows.length > 0) {

        cart_rows.each(function (e) {
            var existing_item_name = $(this).find('td:eq(0) div.prod_modal').text().trim();
            var existing_item_id = $(this).find('td:eq(2) .cart_prod_id').val();
            var existing_item_qty = parseInt($(this).find('td:eq(2) .cart_qty').val());

            if ((existing_item_name == prod_name.trim()) && (existing_item_id == prod_id)) {
                existing_item_qty += 1;
                cart_tr_id = parseInt($(this).attr('id'));
                $(this).find('td:eq(2) .cart_qty').val(0);
                $(this).find('td:eq(2) .cart_qty').val(existing_item_qty);
                return false;
            }
        });
    }

    return cart_tr_id;
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

//            console.log(data);


        }).fail(function (e) {

        });
    }
}

function calculate_grand_total() {

    var grand_total = 0.00;
    var grand_num_item = 0;
    var grand_qty = 0;
    var cart_id = $('#cart_id').val();
    var post_data = {};

    $('#cart-row').find('tr').each(function () {
        grand_total += parseFloat($(this).find('td:eq(3)').text());
        grand_num_item += 1;
        grand_qty += parseInt($(this).find('td:eq(2) .cart_qty').val());
    });

    $('#cart-total tr:last-child th:eq(1)').text(grand_num_item + ' (' + grand_qty + ')');

    var total_vat = parseFloat($('#cart-total tr:first-child th.vat_cell_val').text().trim());
    var total_discount = parseFloat($('#cart-total tr:first-child th.discount_cell_val').text().trim());

    if (total_vat != '' && total_vat > 0) {
        grand_total = grand_total + total_vat;
    }

    if (total_discount != '' && total_discount > 0) {
        grand_total = grand_total - total_discount;
    }

    $('#cart-total tr:last-child th:eq(2)').text(grand_total.toFixed(2));

    var url_action = (cart_id > 0) ? 'edit' : 'add';

    post_data['cart_id'] = cart_id;
    post_data['grand_total'] = grand_total;
    post_data['discount'] = total_discount;
    post_data['vat'] = total_vat;
    post_data['type'] = 'sale';

    $.ajax({
        url: '/cart/' + url_action,
        type: 'post',
        dataType: 'json',
        data: post_data,
    }).done(function (data) {
        cart_id = data.cart_id;
        $('#cart_id').val(cart_id);
        if ($('#cart-row').find('tr').length > 0) {
            add_cart_items();
        }
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
    $(document).on('keypress', function (e) {

        if (e.keyCode == 13) {
            return false;
        }
    });

    $(document).off('click', '.prod_modal').on('click', '.prod_modal', function () {
        var price = parseFloat($(this).parent('td').parent('tr').find('.sell_price').val());
        var cart_row_id = $(this).parent('td').parent('tr').attr('id');
        var cur_stock = parseInt($(this).parent('td').parent('tr').find('.cart_cur_stock').val());
        $('#cart_row_id_container').val(cart_row_id);

        $('#price').val(price.toFixed(2));
        $('#cur_stock').val(cur_stock);
        $('#myModal').modal();
    });

    $(document).off('click', '.vat_cell, .discount_cell').on('click', '.vat_cell, .discount_cell', function () {

        var global_vat = $('#global_vat').val();
        var global_vat_mode = $('#global_vat_mode').val();
        var global_discount = $('#global_discount').val();
        var global_discount_mode = $('#global_discount_mode').val();
        $('#vat').val(global_vat + global_vat_mode);
        $('#discount').val(global_discount + global_discount_mode);
        $('#vatModal').modal('show');
    });

    $(document).off('click', '.vat_discount').on('click', '.vat_discount', function () {

        var vat = $('#vat').val();
        var discount = $('#discount').val();

        var global_vat_mode = $('#global_vat_mode').val();
        var global_discount_mode = $('#global_discount_mode').val();

        var grand_total = parseFloat($('#cart-total tr:last-child th:eq(2)').text());

        if (global_vat_mode == '%' || vat.indexOf("%") > -1) {
            vat = parseFloat(vat);
            vat = (grand_total * vat) / 100;
        } else {
            vat = parseFloat(vat);
        }

        if (global_discount_mode == '%' || discount.indexOf("%") > -1) {
            discount = parseFloat(discount);
            discount = (grand_total * discount) / 100;
        } else {
            discount = parseFloat(discount);
        }

        $('th.vat_cell_val').text(vat.toFixed(2));
        $('th.discount_cell_val').text(discount.toFixed(2));

        $('#vatModal').modal('hide');

        calculate_grand_total();
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
        var cart_id = $('#cart_id').val();
        var item_id = $(this).parent('td').siblings('td:eq(2)').find('.cart_prod_id').val();
        var cart_cur_row = $(this).parent('td').parent('tr');

        var post_data = {
            item_id: item_id,
        };

        $.ajax({
            url: '/cart/remove_item',
            type: 'post',
            dataType: 'json',
            data: {cart_id: cart_id, post_data: post_data},
        }).done(function (data) {

            if (data.success == true) {
                cart_cur_row.remove();
                calculate_grand_total();
            } else {
                alert(data.errors[0]);
            }

        }).fail(function (e) {

        });

    });

    $(document).off('blur', '#ref_num').on('blur', '#ref_num', function () {
        var ref_num = $(this).val();
        if (ref_num == '') {
            return false;
        }

        $.ajax({
            url: '/product/sale/product_stock_info',
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
                                    '<input type="hidden" id="prod_vat_' + v.product_id + '" value="' + v.vat + '" >' +
                                    '<input type="hidden" id="prod_discount_' + v.product_id + '" value="' + v.discount + '" >' +
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
                                data.response[0].price,
                                data.response[0].vat,
                                data.response[0].discount,
                                data.response[0].reference_number
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
            url: '/product/sale/product_stock_info',
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
                        data.response[0].price,
                        data.response[0].vat,
                        data.response[0].discount,
                        data.response[0].reference_number
                        );
            },
            error: function () {

            }
        });
    });

    $(document).off('click', '.btn-payment').on('click', '.btn-payment', function () {
        var grand_total = parseFloat($('#cart-total tr:last-child th:eq(2)').text()).toFixed(2);
        if (isNaN(grand_total)) {
            alert('Invalid cart.');
            return false;
        }
        
        var grand_total_items = $('#cart-total tr:last-child th:eq(1)').text();
        var cart_id = $('#cart_id').val();
        var advance_amount = (grand_total * 60) / 100;
        var due_amount = grand_total - advance_amount;
        
        $('#advance_amount').val(advance_amount.toFixed(2));
        $('#payment-total-due').text(due_amount.toFixed(2));
        $('#payment-total-items').text(grand_total_items);
        $('#payment-total-payable').text(grand_total);
        $('#payment_cart_row_id_container').val(cart_id);

        $('#paymentModal').modal('show');
    });

    $(document).off('change', '#paymentModal #payment_mode').on('change', '#paymentModal #payment_mode', function (e) {
        var payment_mode = parseInt($('#paymentModal #payment_mode').val());
        var grand_total = parseFloat($('#cart-total tr:last-child th:eq(2)').text());
        var total_balance = 0.00;

        if (payment_mode > 0) {
            $('.card_information').show('slow');

            $('#paying_amount').prop('readonly', true);
            $('#paying_amount').val(grand_total.toFixed(2));
            $('#payment-total-paying').text(grand_total.toFixed(2));
            total_balance = grand_total - grand_total;
            $('#payment-total-balance').text(total_balance.toFixed(2));

        } else {
            $('#paying_amount').prop('readonly', false);
            $('.card_information').hide('slow');
        }
    });

    $(document).off('keyup', '#advance_amount').on('keyup', '#advance_amount', function (e) {
        
        var grand_total = parseFloat($('#cart-total tr:last-child th:eq(2)').text());
        var advance_amount = parseFloat($(this).val());
        var due_amount = grand_total - advance_amount;

        if (!isNaN(advance_amount)) {
            due_amount = grand_total - advance_amount;
            $('#payment-total-due').text(due_amount.toFixed(2));
        } else {
            $('#payment-total-due').text(0.00);
            alert('Number only.');
        }

    });
    
    $(document).off('keyup', '#paying_amount').on('keyup', '#paying_amount', function (e) {
        
        var amount = parseFloat($(this).val());
        var total_balance = 0.00;
        var advance_amount = parseFloat($('#advance_amount').val());

        if (!isNaN(amount)) {
            $('#payment-total-paying').text(amount.toFixed(2));
            total_balance = amount - advance_amount;
            $('#payment-total-balance').text(total_balance.toFixed(2));
        } else {
            alert('Number only.');
        }

    });

    $(document).off('click', '#paymetn-btn-paid').on('click', '#paymetn-btn-paid', function (e) {
        e.preventDefault();
        var total_balance = 0.00;
        var cart_id = $('#payment_cart_row_id_container').val();
        var note = $('#note').val();
        var payment_method = $('#payment_mode').val();
        var payment_amount = $('#paying_amount').val();
        var advance_amount = parseFloat($('#advance_amount').val());
        var card_number = $('#card_number').val();
        var card_cvc = $('#card_cvc').val();
        var card_type = $('#card_option').val();
        var bill_number = $('#ProductStockSales_billnumber').val();
        var sale_date = $('#ProductStockSales_sale_date').val();
        var due_payment_date = $('#ProductStockSales_due_payment_date').val();
        var post_data = {};
        
        if (parseFloat(payment_amount) < advance_amount) {
            total_balance = advance_amount - payment_amount;
            alert('Bill amount is not completly paid. Need BDT ' + total_balance + ' more to process the sale.');
            return false;
        }
        
        post_data['type'] = 'advanceSale';
        post_data['note'] = note;
        post_data['payment_method'] = payment_method;
        post_data['payment_amount'] = payment_amount;
        post_data['payment_advance'] = advance_amount;
        post_data['card_number'] = card_number;
        post_data['card_cvc'] = card_cvc;
        post_data['card_type'] = card_type;
        post_data['bill_number'] = bill_number;
        post_data['sale_date'] = sale_date;
        post_data['due_payment_date'] = due_payment_date;

        $.ajax({
            url: '/cart/payment',
            type: 'post',
            dataType: 'json',
            data: {cart_id: cart_id, post_data: post_data},
        }).done(function (data) {

            if (data.html != '') {

                if ($('.print').length > 0) {

                    $('.print .print-wrapper .bill_table').html('');
                    $('.print .print-wrapper .bill_table').html(data.html);

                    var bill_number = $('.print .hidden_bill_number').text().trim();
                    var sale_date = $('.print .hidden_sale_date').text().trim();

                    $('.print .bill-date span').html('');
                    $('.print .bill-date span').html(sale_date);

                    $('.print .bill-number span').html('');
                    $('.print .bill-number span').html(bill_number);

                    $('.print').find('table').attr('cellspacing', '0');
                    $('.print .bill-date span').html(sale_date);

                    $('#btn-print').trigger('click');
                }
            }

            $('#paymentModal').modal('hide');

            window.location.reload();
        }).fail(function (e) {
            console.log(e);
        });

        return false;
    });

    $(document).off('click', '.cart-print').on('click', '.cart-print', function (e) {

        var printable = $('.printable').html();
        var sale_date = $('#ProductStockSales_sale_date').val();

        if ($('.print').length > 0) {

            $('.print .print-wrapper .bill_table').html('');
            $('.print .print-wrapper .bill_table').html(printable);

            var vat_val = $('.vat_cell_val').text();
            var dis_val = $('.discount_cell_val').text();
            var gross_total_row = $('.print .print-wrapper .bill_table table tfoot#cart-total tr:last-child').html();

            $('.print .print-wrapper .bill_table table tfoot#cart-total tr:first-child').remove();
            $('.print .print-wrapper .bill_table table tfoot#cart-total tr:last-child').remove();

            var tfoot = '<tr>' +
                    '<th colspan="3" class="vat_cell">Vat</th><th class="vat_cell_val">' + parseFloat(vat_val).toFixed(2) + '</th><th></th>' +
                    '</tr>' +
                    '<tr>' +
                    '<th colspan="3" class="discount_cell">Discount</th><th class="discount_cell_val">' + parseFloat(dis_val).toFixed(2) + '</th><th></th>' +
                    '</tr>' +
                    '<tr>' + gross_total_row + '</tr>';
            $('.print .print-wrapper .bill_table table tfoot#cart-total').html(tfoot);

            $('.print').find('table tr').each(function (e) {
                $(this).find('th:last-child').remove();
                $(this).find('td:last-child').remove();
                $(this).find('td:eq(2) input.cart_qty').remove();
                $(this).find('td:eq(2) label.cart_qty_lbl').show();
            });

            $('.print').find('table').attr('cellspacing', '0');
            $('.print .bill-date span').html(sale_date);

            $('#btn-print').trigger('click');
        }


    });

    /** TILL THIS FIXED **/

});