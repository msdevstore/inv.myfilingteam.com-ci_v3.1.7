<?php include'invoice_val.php'; ?>

<div class="card-body p-0">
    <div class="row p-30" style="width: 100%">
        <div class="col-6" style="width: 45%; float: left;">
            <?php if (!empty($qr_code)): ?>
                <p><img class="qr_code_sm" src="<?php echo base_url($qr_code) ?>" alt="QR Code"></p>
            <?php endif; ?>
            <?php if (empty($logo)): ?>
                <p><span class="alterlogo"><?php echo $business_name ?></span></p>
            <?php else: ?>
                <img width="130px" src="<?php echo base_url($logo) ?>" alt="Logo">
            <?php endif ?>
        </div>
        <div class="col-6 text-right" style="width: 45%; float: right; margin-top: -10px">
            <p class="mb-0"><strong><?php echo html_escape($business_name) ?></strong></p>
            <p class="font-weight-bold mb-0"><?php echo html_escape($title) ?> <br><?php echo html_escape($summary) ?></p>
            
            
            <?php if (!empty($biz_number)): ?>
            <p class="mb-0"><?php echo trans('business-number') ?>: <?php echo html_escape($biz_number) ?></p>
            <?php endif ?>

            <?php if (!empty($biz_vat_code)): ?>
            <p class="mb-0"><?php echo trans('taxvat-number') ?>: <?php echo html_escape($biz_vat_code) ?></p>
            <?php endif ?>

            <span class="mb-0 invbiz"><?php echo $business_address ?></span>
            <?php if (!empty($business_phone)): ?>
            <p class="mb-0"><?php echo html_escape($business_phone) ?></p>
            <?php endif ?>

            <p class=""><?php echo html_escape($country) ?></p>
        </div>
    </div>

    <div class="my-5"></div>

    <div class="flex-parent-between bill_area" style="width: 100%">
        <div class="py-4 pl-30 pr-30" style="width: 45%; float: left;">
            
            <h5 class="font-weight-bold"><?php echo trans('bill-to') ?></h5>
       
            <?php if (empty($customer_id)): ?>
                <p class="mb-1"><?php echo trans('empty-customer') ?></p>
            <?php else: ?>
                <p class="mb-1" style="font-family: 'DM Sans', sans-serif;">
                    <?php if (!empty(helper_get_customer($customer_id))): ?>
                        <p class="mb-0"><strong><?php echo helper_get_customer($customer_id)->name ?></strong></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->address ?> <?php echo helper_get_customer($customer_id)->country ?></p>
                        <p class="mt-0 mb-0"><?php echo helper_get_customer($customer_id)->phone ?></p>
                        
                        <?php if (!empty($cus_number)): ?>
                        <p class="mt-0 mb-0"><?php echo trans('business-number') ?>: <?php echo html_escape($cus_number) ?></p>
                        <?php endif ?>

                        <?php if (!empty($cus_vat_code)): ?>
                        <p class="mt-0"><?php echo trans('taxvat-number') ?>: <?php echo html_escape($cus_vat_code) ?></p>
                        <?php endif ?>

                    <?php endif ?>
                </p>
            <?php endif ?>
        </div>

        <div class="py-4 text-right" style="width: 45%; float: right; text-align: right; margin-right: -105px;">
            <table class="tables">
                <tr>
                    <td><b class="mr-10"><?php if(isset($page) && $page == 'Invoice'){echo trans('invoice-number');}else{echo trans('estimate-number');} ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo html_escape($number) ?></td>
                </tr>
                <tr>
                    <td><b class="mr-10"><?php if(isset($page) && $page == 'Invoice'){echo trans('invoice-date');}else{echo trans('estimate-date');} ?>:</b></td>
                    <td class="text-left" colspan="1"><?php echo my_date_show($date) ?></td>
                </tr>
                <?php if (!empty($poso_number)): ?>
                    <tr>
                        <td><b class="mr-10"><?php echo trans('p.o.s.o.-number') ?>:</b></td>
                        <td class="text-left" colspan="1"><?php echo html_escape($poso_number) ?></td>
                    </tr>
                <?php endif ?>
                <?php if(isset($page) && $page == 'Invoice'):?>
                    <tr>
                        <td><b class="mr-10"><?php echo trans('due-date') ?>:</b></td>
                        <td class="text-left">
                            <?php echo my_date_show($payment_due) ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="text-left">
                            <?php if ($due_limit == 1): ?>
                                <p><?php echo trans('on-receipt') ?></p>
                            <?php else: ?>
                                <p><?php echo trans('within') ?> <?php echo html_escape($due_limit) ?> <?php echo trans('days') ?></p>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><b class="mr-10"><?php echo trans('expires-on') ?>:</b></td>
                        <td class="text-left">
                        <?php echo my_date_show($invoice->expire_on) ?>
                    </td>
                </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>

    <div class="row p-0 table_area">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="pre_head2">
                    <tr class="pre_head_tr2 inv-pl30">
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('items') ?></th>
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('hsn') ?></th>
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('quantity') ?></th>
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('unit') ?></th>
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('price') ?></th>
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('gst') ?></th>
                        <th class="border-0" style="color: #fff; background: <?php echo html_escape($color) ?>; font-weight: bold; "><?php echo trans('amount') ?></th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (isset($page_title) && $page_title == 'Invoice Preview'): ?>
                        <?php if (!empty($this->session->userdata('item'))): ?>
                            <?php $total_items = count($this->session->userdata('item')); ?>
                        <?php else: ?>
                            <?php $total_items = 0; ?>
                        <?php endif ?>
                        
                        <?php if (empty($total_items)): ?>
                            <tr>
                                <td colspan="5" class="text-center"><?php echo trans('empty-items') ?></td>
                            </tr>
                        <?php else: ?>
                            <?php for ($i=0; $i < $total_items; $i++) { ?>
                                <tr class="inv-pl30">
                                    <td width="50%">
                                    <?php $product_id = $this->session->userdata('item')[$i] ?>
                                    
                                    <?php if (is_numeric($product_id)) {
                                         echo helper_get_product($product_id)->name.'<br> <small>'. nl2br(helper_get_product($product_id)->details).'</small>';
                                    } else {
                                        echo html_escape($product_id);
                                    } ?>
                                    </td>
                                    <td><?php echo $this->session->userdata('hsn')[$i] ?></td>
                                    <td><?php echo $this->session->userdata('quantity')[$i] ?></td>
                                    <td><?php echo $this->session->userdata('unit')[$i] ?></td>
                                    <td><?php echo price_formatted_alt($this->session->userdata('price')[$i], $business_id, $currency_symbol) ?></td>
                                    <td><?php echo $this->session->userdata('tax_name')[$i] ?></td>
                                    <td>
                                        <?php echo price_formatted_alt($this->session->userdata('total_price')[$i], $business_id, $currency_symbol) ?>   
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>

                    <?php else: ?>

                        <?php $items = helper_get_invoice_items($invoice->id) ?>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="5" class="text-center"><?php echo trans('empty-items') ?></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($items as $item): ?>
                                <tr class="inv-pl30">
                                    <td width="25%"><?php echo html_escape($item->item_name) ?> <br> <small><?php echo nl2br($item->details) ?></small></td>
                                    <td><?php echo html_escape($item->hsn) ?></td>
                                    <td><?php echo html_escape($item->qty) ?></td>
                                    <td><?php echo html_escape($item->unit) ?></td>
                                    <td><?php echo price_formatted_alt($item->price, $business_id, $currency_symbol) ?></td>
                                    <td><?php echo html_escape($item->tax_name) ?> - <?php echo html_escape($item->tax_rate) ?> %</td>
                                    <td><?php echo price_formatted_alt($item->total, $business_id, $currency_symbol) ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endif ?>

                    <tr class="inv-pl30">
                        <td></td>
                        <td></td>
                        <td colspan="4" class="text-right"><strong><?php echo trans('sub-total') ?></strong></td>
                        <td><span><?php echo price_formatted_alt($sub_total, $business_id, $currency_symbol) ?></span></td>
                    </tr>

                    <?php if (!empty($discount)): ?>
                        <tr class="inv-pl30">
                            <td></td>
                            <td></td>
                            <td colspan="4" class="text-right"><strong><?php echo trans('discount') ?> <?php echo html_escape($discount) ?>%</strong></td>
                            <td><span><?php echo price_formatted_alt($sub_total * ($discount / 100), $business_id, $currency_symbol) ?></span></td>
                        </tr>
                    <?php endif ?>
                    
                    <?php $i=1; foreach ($items as $item): ?>
                        <tr class="inv-pl30 t78">
                            <td></td>
                            <td></td>
                            <td colspan="4" class="text-right"><strong><?php echo html_escape($item->tax_name) ?> - <?php echo html_escape($item->tax_rate) ?> %</strong></td>
                            <td><?php 
                                echo price_formatted_alt($item->total * (1 - $discount / 100) * $item->tax_rate / 100, $this->business->id, $currency_symbol);
                            ?></td>
                        </tr>
                    <?php $i++; endforeach ?>
                    
                    <tr class="inv-pl30">
                        <td></td>
                        <td></td>
                        <td colspan="4" class="text-right"><strong><?php echo trans('adjustment') ?></strong></td>
                        <td><span><?php echo price_formatted_alt($invoice->adjustment, $this->business->id, $currency_symbol) ?></span></td>
                    </tr>
                    
                    <tr class="inv-pl30">
                        <td></td>
                        <td></td>
                        <td colspan="4" class="text-right"><strong><?php echo trans('grand-total') ?></strong></td>
                        <td><span><?php echo price_formatted_alt($grand_total,$business_id, $currency_symbol) ?></span></td>
                    </tr>


                    <?php foreach (get_invoice_payments($invoice->id) as $payment): ?>
                        <tr class="inv-pl30 text-dark">
                            <td></td>
                            <td></td>
                            <td colspan="4" class="text-right">
                                <span class="fs-13"><strong><?php echo trans('payment-on') ?> <?php echo my_date_show($payment->payment_date) ?> <?php echo trans('using') ?> <?php echo get_using_methods($payment->payment_method) ?></strong></span>
                            </td>
                            <td>
                                <span class="fs-13"><strong><?php echo price_formatted_alt($payment->amount, $business_id, $currency_symbol) ?></strong></span>
                            </td>
                        </tr>
                    <?php endforeach ?>

                    <tr class="inv-pl30">
                        <td></td>
                        <td></td>
                        <td colspan="4" class="text-right bg-mlight"><strong><?php echo trans('amount-due') ?></strong></td>
                        <td class="bg-mlight">
                            <span>
                                <?php if ($status == 2): ?>
                                    <?php echo price_formatted_alt('0', $business_id, $currency_symbol) ?>
                                <?php else: ?>
                                    <?php if (isset($page_title) && $page_title == 'Invoice Preview'): ?>
                                        <?php echo price_formatted_alt($grand_total, $business_id, $currency_symbol) ?>
                                    <?php else: ?>
                                        <?php echo price_formatted_alt($grand_total - get_total_invoice_payments($invoice->id, 0), $business_id, $currency_symbol); ?>
                                    <?php endif ?>
                                <?php endif ?>
                            </span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <div class="p-30 text-<?php echo html_escape($footer_note_align) ?>">
        <p class="text-centers"><?php echo $footer_note ?></p>
    </div>
</div>