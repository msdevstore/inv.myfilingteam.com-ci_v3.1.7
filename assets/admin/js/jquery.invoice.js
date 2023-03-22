
(function (jQuery) {
    $.opt = {};  // jQuery Object

    jQuery.fn.invoice = function (options) {
        var ops = jQuery.extend({}, jQuery.fn.invoice.defaults, options);
        $.opt = ops;

        var inv = new Invoice();
        inv.init();

        jQuery('body').on('click', function (e) {
            var cur = e.target.id || e.target.className;

            if (cur == $.opt.addRow.substring(1))
                inv.newRow();

            if (cur == $.opt.delete.substring(1))
                inv.deleteRow(e.target);

            if (e.target.id != 'discount' && e.target.id != 'adjustment') {
                inv.init();
            }
        });

        jQuery('body .tax_id').on('click', 'option', function (e) {
            inv.init();
        });

        jQuery('body #add_item').on('change keyup', function (e) {
            inv.init();
        });

        $(document).on('change', '#discount', function(e) {
            inv.init();
        });
        
        $(document).on('change', '#adjustment', function(e) {
            inv.init();
        });

        return this;
    };
}(jQuery));

function Invoice() {
    self = this;
}

Invoice.prototype = {
    constructor: Invoice,

    init: function () {
        jQuery('#info').empty();
        // this.calcTax();
        this.calcTotal();
        this.calcTotalQty();
        this.calcSubtotal();
        // this.calcGrandTotal();
    },

    /**
     * Calculate total price of an item.
     *
     * @returns {number}
     */
    calcTotal: function () {
         jQuery($.opt.parentClass).each(function (i) {
             var row = jQuery(this);
             var total = row.find($.opt.price).val() * row.find($.opt.qty).val();

             total = self.roundNumber(total, 2);

             row.find($.opt.total).html(total);
             row.find($.opt.total).val(total);
         });

         return 1;
     },
	
    /***
     * Calculate total quantity of an order.
     *
     * @returns {number}
     */
    calcTotalQty: function () {
         var totalQty = 0;
         jQuery($.opt.qty).each(function (i) {
             var qty = jQuery(this).val();
             if (!isNaN(qty)) totalQty += Number(qty);
         });

         totalQty = self.roundNumber(totalQty, 2);

         jQuery($.opt.totalQty).html(totalQty);

         return 1;
     },

    /***
     * Calculate subtotal of an order.
     *
     * @returns {number}
     */
    calcSubtotal: function () {
         let subtotal = 0;
         jQuery($.opt.total).each(function (i) {
             let total = jQuery(this).html();
             if (!isNaN(total)) subtotal += Number(total);
         });

         var browser = jQuery('#browser').val();
         if (browser == 'Firefox') {
            subtotal = subtotal/2;
         }
         
         let discount = Number($('.discount').val());

         let total_discount = subtotal * discount / 100;
         let rprice = subtotal - total_discount;
         total_discount = self.roundNumber(total_discount, 2);

         subtotal = self.roundNumber(subtotal, 2);
         jQuery('.subtotal').val(subtotal);


         let mark = jQuery($.opt.currency_wrapper).val();

         let temp = '<tr>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td colspan="4" class="text-right"><strong>Sub Total: </strong></td>' +
                '<td class="text-right">' + mark + ' ' + subtotal + '</td>' +
            '</tr>' +
            '<tr>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td colspan="4" class="text-right"><strong>Discount </strong><input id="discount" style="width: 50px" value="' + discount + '"> %<strong>:</strong></td>' +
                '<td class="text-right" id="total_discount">' + mark + ' - ' + total_discount + '</td>' +
            '</tr>';

            
        var totaltax = 0;

        jQuery($.opt.parentClass).each(function (i) {
            var row = jQuery(this);
            var price = row.find($.opt.price).val();
            if (price != undefined) {
                let tax_rate = row.find($.opt.tax).val();
                if(tax_rate == '') tax_rate = 0;
                let qty = row.find($.opt.qty).val();
                let rtax = Number(price) * Number(qty) * (1 - discount / 100) * Number(tax_rate) / 100;
                totaltax += rtax;
                rtax = self.roundNumber(rtax, 2);
                let tax_name = row.find($.opt.tax_name).val();
                if(tax_name == '') tax_name = 'No Tax';
                temp += '<tr>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td></td>' +
                            '<td colspan="4" class="text-right"><strong>' + tax_name + ' (' + tax_rate + '%)' + ': </strong></td>' +
                            '<td class="text-right">' + mark + ' ' + rtax + '</td>' +
                        '</tr>';
            }
        });

        let adjustment = Number($('.adjustment').val());
        let grandTotal = rprice + totaltax + adjustment;
        grandTotal = self.roundNumber(grandTotal, 2);

         temp += '<tr>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td colspan="4" class="text-right"><strong>Adjustment </strong><input id="adjustment" style="width: 50px" value="' + adjustment + '"> <strong>:</strong></td>';
        adjustment = self.roundNumber(adjustment, 2);
         temp += '<td class="text-right" id="adjustment">' + mark + ' ' + adjustment + '</td>' +
            '</tr>' +
            '<tr>' +
                '<td></td>' +
                '<td></td>' +
                '<td></td>' +
                '<td colspan="4" class="text-right"><strong>Total: </strong></td>' +
                '<td class="text-right">' + mark + ' ' + grandTotal + '</td>' +
            '</tr>';
         jQuery('#info').append(temp);
            
         totaltax = self.roundNumber(totaltax, 2);
         
         jQuery('.totaltax').val(totaltax);
         jQuery('.discount').val(discount);
         jQuery('.adjustment').val(adjustment);
         jQuery('.grandtotal').val(grandTotal);

         return 1;
     },




     /***
     * Calculate tax.
     *
     * @returns {number}
     */

    // calcTax: function () {
    //     var totaltax = 0;
    //     jQuery($.opt.tax).each(function (i) {
    //         var tax = jQuery(this).val();
    //         if (!isNaN(tax)) totaltax += Number(tax);
    //     });

    //     totaltax = self.roundNumber(totaltax, 2);
    //     jQuery('.total_tax').val(totaltax);
            
    //     return 1;
    // },


    /**
     * Calculate grand total of an order.
     *
     * @returns {number}
     */
    calcGrandTotal: function () {

        var total_discount = Number(jQuery($.opt.discount).val());
        var tax = jQuery($.opt.total_tax).val();

        var grandTotal = Number(jQuery($.opt.subtotal).html()) - (Number(jQuery($.opt.subtotal).html()) * (Number(total_discount)/100));

        var finalTotal = grandTotal + (grandTotal * (Number(tax)/100));

        grandTotal = self.roundNumber(finalTotal, 2);
        
        jQuery($.opt.grandTotal).html(grandTotal);
        jQuery('.grandtotal').val(grandTotal);




        return 1;
    },

    /**
     * Add a row.
     *
     * @returns {number}
     */
    newRow: function () {
        var base_url = $('#base_url').val();
        
        var url = base_url+'admin/invoice/load_gsts';
        
        $.post(url,{ data: 'value', 'csrf_test_name': csrf_token }, function(data){
          const gsts = JSON.parse(data);
          let temp = '';
          gsts.forEach((gst) => {
              temp += `<optgroup label="${gst.name}">`;
              gst.taxes.forEach(tax => {
                  temp += `<option value="${tax.id}">${tax.name} - ${tax.rate}%</option>`;
              });
              temp += `</optgroup>`;
          });
          
          let len = $('.new-item').length;
          
            jQuery(".item-row:last").after(`
                <tr class="item-row new-item">
                    <td width="15%" class="item-name">
                        <input type="text" name="items[]" class="form-control item ws-180" placeholder="Item" type="text">
                    </td>
                    <td width="25%">
                        <textarea name="details[]" class="form-control ac-textarea ws-180" rows="1" placeholder=""></textarea>
                    </td>
                    <td width="8%">
                        <input type="text" class="form-control hsn" placeholder="" type="text" name="hsn[]">
                    </td>
                    <td width="8%"><input class="form-control qty ws-100" name="quantity[]" placeholder="Qty" type="text" value="1"></td>
                    <td width="7%">
                        <input type="text" class="form-control unit" placeholder="" type="text" name="unit[]" value="">
                    </td>
                    <td width="8%"><input class="form-control price invo ws-100" name="price[]" placeholder="Price" type="text" value="0"> </td>
                    <td width="14%">
                        <select class="form-control tax_id" data-id="s${len}" id="tax_id_s${len}" name="taxes[]">
                            <option value="0">Select Tax</option>
                            ${temp}
                        </select>
                        <input type="hidden" class="tax" id="tax_s${len}" value="">
                        <input type="hidden" class="tax_name" id="tax_name_s${len}" value="">
                    </td>
                    <td width="15%"><div class="delete-btn"><span class="currency_wrapper"></span><span class="total">0.00</span><a class="delete" href="javascript:;" title="Remove row">&times;</a><input type="hidden" class="total" name="total_price[]" value=""><input type="hidden" name="product_ids[]" value="0"></div></td>
                </tr>`);
            if (jQuery($.opt.delete).length > 0) {
                jQuery($.opt.delete).show();
            }
    
            return 1;
        });
    },


    /**
     * Delete a row.
     *
     * @param elem   current element
     * @returns {number}
     */
    deleteRow: function (elem) {
        jQuery(elem).parents($.opt.parentClass).remove();

        if (jQuery($.opt.delete).length < 2) {
            jQuery($.opt.delete).hide();
        }

        return 1;
    },

    /**
     * Round a number.
     * Using: http://www.mediacollege.com/internet/javascript/number/round.html
     *
     * @param number
     * @param decimals
     * @returns {*}
     */
    roundNumber: function (number, decimals) {
        var newString;// The new rounded number
        decimals = Number(decimals);

        if (decimals < 1) {
            newString = (Math.round(number)).toString();
        } else {
            var numString = number.toString();

            if (numString.lastIndexOf(".") == -1) {// If there is no decimal point
                numString += ".";// give it one at the end
            }

            var cutoff = numString.lastIndexOf(".") + decimals;// The point at which to truncate the number
            var d1 = Number(numString.substring(cutoff, cutoff + 1));// The value of the last decimal place that we'll end up with
            var d2 = Number(numString.substring(cutoff + 1, cutoff + 2));// The next decimal, after the last one we want

            if (d2 >= 5) {// Do we need to round up at all? If not, the string will just be truncated
                if (d1 == 9 && cutoff > 0) {// If the last digit is 9, find a new cutoff point
                    while (cutoff > 0 && (d1 == 9 || isNaN(d1))) {
                        if (d1 != ".") {
                            cutoff -= 1;
                            d1 = Number(numString.substring(cutoff, cutoff + 1));
                        } else {
                            cutoff -= 1;
                        }
                    }
                }

                d1 += 1;
            }

            if (d1 == 10) {
                numString = numString.substring(0, numString.lastIndexOf("."));
                var roundedNum = Number(numString) + 1;
                newString = roundedNum.toString() + '.';
            } else {
                newString = numString.substring(0, cutoff) + d1.toString();
            }
        }

        if (newString.lastIndexOf(".") == -1) {// Do this again, to the new string
            newString += ".";
        }

        var decs = (newString.substring(newString.lastIndexOf(".") + 1)).length;

        for (var i = 0; i < decimals - decs; i++)
            newString += "0";
        //var newNumber = Number(newString);// make it a number if you like

        return newString; // Output the result to the form field (change for your purposes)
    }
};

/**
 *  Publicly accessible defaults.
 */
jQuery.fn.invoice.defaults = {
    addRow: "#addRow",
    delete: ".delete",
    parentClass: ".item-row",

    price: ".price",
    qty: ".qty",
    total: ".total",
    totalQty: "#totalQty",

    currency_wrapper: "#currency_wrapper",

    subtotal: "#subtotal",
    discount: "#discount",
    tax: ".tax",
    tax_name: ".tax_name",
    total_tax: ".total_tax",
    taxId: "#tax_id",
    shipping: "#shipping",
    grandTotal: "#grandTotal"
};
