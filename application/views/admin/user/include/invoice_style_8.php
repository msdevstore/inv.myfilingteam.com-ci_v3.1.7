<?php include'invoice_val.php'; ?>

<div class="card-body p-0">

    <div class="flex-parent-between inv6-header">
        <div class="inv6">
            <?php if (empty($logo)): ?>
                <span class="alterlogo p-0" style="color: <?php echo html_escape($color) ?>"><?php echo $business_name ?></span>
            <?php else: ?>
                <img width="130px" src="<?php echo base_url($logo) ?>" alt="Logo">
            <?php endif ?>
            <h5 class="mb-1 text-left"><?php echo html_escape($title) ?></h5>
            <p class="text-left"><?php echo html_escape($summary) ?></p>
        </div>
   
        <div class="inv6">
            <h3 class="mb-1 text-right"><?php if(isset($page) && $page == 'Invoice'){echo trans('invoice');}else{echo trans('estimate');} ?></h3>
            <p class="text-right"># <?php echo html_escape($number) ?></p>

            <p class="mb-1 mr-0 st8_toph"><strong><?php if(isset($page) && $page == 'Invoice'){echo trans('invoice-date');}else{echo trans('estimate-date');} ?></strong>: <span><?php echo my_date_show($date) ?></span></p>

            <?php if (!empty($poso_number)): ?>
            <p class="mb-1 mr-0 st8_toph"><strong><?php echo trans('p.o.s.o.-number') ?></strong>: <span><?php echo html_escape($poso_number) ?></span></p>
            <?php endif ?>


            <p class="mb-1 mr-0 text-right st8_toph">
                <strong><?php echo trans('amount-due') ?></strong>
  
                <?php if ($status == 2): ?>
                    <?php echo price_formatted_alt('0', $this->business->id, $currency_symbol) ?>
                <?php else: ?>
                    <?php if (isset($page_title) && $page_title == 'Invoice Preview'): ?>
                        <?php echo price_formatted_alt($grand_total, $this->business->id, $currency_symbol) ?>
                    <?php else: ?>
                        <?php echo price_formatted_alt($grand_total - get_total_invoice_payments($invoice->id, 0), $this->business->id, $currency_symbol); ?>
                    <?php endif ?>
                <?php endif ?>
            </p>

            <?php if(isset($page) && $page == 'Invoice'):?>
                <p class="mb-1 pull-right st8_toph"><strong><?php echo trans('due-date') ?></strong>: <span><?php echo my_date_show($payment_due) ?></span>
                <?php if ($due_limit == 1): ?>
                    <p class="st8_tophs"><small class="pull-right">(<?php echo trans('on-receipt') ?>)</small></p>
                <?php else: ?>
                    <p><small class="pull-right st8_tophs">(<?php echo trans('within') ?> <?php echo html_escape($due_limit) ?> <?php echo trans('days') ?>)</small></p>
                <?php endif ?>
                </p>
            <?php else: ?>
                <p class="mb-1 mr-5 st8_toph"><strong><?php echo trans('expires-on') ?></strong>: <span><?php echo my_date_show($invoice->expire_on) ?></span></p>
            <?php endif; ?>

        </div>
    </div>

    <hr class="my-5">

    <div class="flex-parent-between invtem_top_2" style="background: <?php echo html_escape($color) ?>; color: #fff;">

        <div class="col-6s text-left">
           
            <h5 class="font-weight-bold text-white"><?php echo trans('bill-to') ?></h5>
            
            <?php if (empty($customer_id)): ?>
                <p class="mb-1 mt-0"><?php echo trans('empty-customer') ?></p>
            <?php else: ?>
                <p class="mb-1">
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

        <div class="col-6s text-right">
            <p class="mb-0"><strong><?php echo html_escape($business_name) ?></strong></p>
            
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

 

    <div class="row p-0 mt-20 table_area">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="pre_head2">
                    <tr class="pre_head_tr2 inv-pl30">
                        <th class="border-0 font-weight-bold" style="color: <?php echo html_escape($color) ?>"><?php echo trans('items') ?></th>
                        <th class="border-0 font-weight-bold" style="color: <?php echo html_escape($color) ?>"><?php echo trans('price') ?></th>
                        <th class="border-0 font-weight-bold" style="color: <?php echo html_escape($color) ?>"><?php echo trans('quantity') ?></th>
                        <th class="border-0 font-weight-bold" style="color: <?php echo html_escape($color) ?>"><?php echo trans('amount') ?></th>
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
                                <tr class="inv-pl30  t78<?php if($i % 2 == 0){echo "bg-blight";} ?>">
                                    <td width="50%">
                                        <?php $product_id = $this->session->userdata('item')[$i] ?>
                                        
                                        <?php if (is_numeric($product_id)) {
                                            echo helper_get_product($product_id)->name.'<br> <small>'. nl2br(helper_get_product($product_id)->details).'</small>';
                                        } else {
                                            echo html_escape($product_id);
                                        } ?>
                                    </td>
                                    <td><?php echo price_formatted_alt($this->session->userdata('price')[$i], $this->business->id, $currency_symbol) ?></td>
                                    <td><?php echo $this->session->userdata('quantity')[$i] ?></td>
                                    <td>
                                        <?php echo price_formatted_alt($this->session->userdata('total_price')[$i], $this->business->id, $currency_symbol) ?>   
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php endif ?>
                    <?php else: ?>
                        <?php if ($invoice->parent_id == 0){$invo_id = $invoice->id;}else{$invo_id = $invoice->parent_id;} ?>

                        <?php $items = helper_get_invoice_items($invo_id) ?>
                        <?php if (empty($items)): ?>
                            <tr>
                                <td colspan="5" class="text-center"><?php echo trans('empty-items') ?></td>
                            </tr>
                        <?php else: ?>
                            <?php $i=1; foreach ($items as $item): ?>
                                <tr class="inv-pl30 t78">
                                    <td width="50%"><?php echo html_escape($item->item_name) ?> <br> <small><?php echo nl2br($item->details) ?></small></td>
                                    <td><?php echo price_formatted_alt($item->price, $this->business->id, $currency_symbol) ?></td>
                                    <td><?php echo html_escape($item->qty) ?></td>
                                    <td><?php echo price_formatted_alt($item->total, $this->business->id, $currency_symbol) ?></td>
                                </tr>
                            <?php $i++; endforeach ?>
                        <?php endif ?>
                    <?php endif ?>

                    <tr class="inv-pl30">
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong><?php echo trans('sub-total') ?></strong></td>
                        <td><span><?php echo price_formatted_alt($sub_total, $this->business->id, $currency_symbol) ?></span></td>
                    </tr>

                    <?php if (!empty($taxes)): ?>
                        <?php foreach ($taxes as $tax): ?>
                            <?php if ($tax != 0): ?>
                                <tr class="inv-pl30">
                                    <td></td>
                                    <td></td>
                                    <td class="text-right"><strong><?php echo get_tax_id($tax)->type_name.' ('.get_tax_id($tax)->name.'-'.get_tax_id($tax)->number.') '.get_tax_id($tax)->rate.'%' ?></strong></td>
                                    <td><span><?php echo price_formatted_alt($sub_total * (get_tax_id($tax)->rate / 100), $this->business->id, $currency_symbol) ?></span></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                    
                    <?php if (!empty($discount)): ?>
                        <tr class="inv-pl30">
                            <td></td>
                            <td></td>
                            <td class="text-right"><strong><?php echo trans('discount') ?> <?php echo html_escape($discount) ?>%</strong></td>
                            <td><span><?php echo price_formatted_alt($sub_total * ($discount / 100), $this->business->id, $currency_symbol) ?></span></td>
                        </tr>
                    <?php endif ?>
                    

                    <tr class="inv-pl30">
                        <td></td>
                        <td></td>
                        <td class="text-right"><strong><?php echo trans('grand-total') ?></strong></td>
                        <td><span><?php echo price_formatted_alt($grand_total,$this->business->id, $currency_symbol) ?></span></td>
                    </tr>


                    <?php foreach (get_invoice_payments($invoice->id) as $payment): ?>
                        <tr class="inv-pl30 text-dark">
                            <td></td>
                            <td></td>
                            <td class="text-right" width="60%">
                                <span class="fs-13"><strong><?php echo trans('payment-on') ?> <?php echo my_date_show($payment->payment_date) ?> <?php echo trans('using') ?> <?php echo get_using_methods($payment->payment_method) ?></strong></span>
                            </td>
                            <td>
                                <span class="fs-13"><strong><?php echo price_formatted_alt($payment->amount, $this->business->id, $currency_symbol) ?></strong></span>
                            </td>
                        </tr>
                    <?php endforeach ?>



                </tbody>
            </table>

            <?php if (!empty($qr_code)): ?>
                <img class="qr_code_sm ml-30" src="<?php echo base_url($qr_code) ?>" alt="QR Code">
            <?php endif; ?>
        </div>
    </div>

    <div class="p-30 text-<?php echo html_escape($footer_note_align) ?>">
        <p class="text-centers"><?php echo $footer_note ?></p>
    </div>

</div>