
    <tr class="item-row">
        <td width="15%">
            <input type="text" class="form-control item ws-180" placeholder="Item" type="text" name="items[]" value="<?php echo html_escape($product->name) ?>">
        </td>
        <td width="25%">
            <textarea name="details[]" class="form-control ac-textarea ws-180" rows="1" placeholder="<?php echo trans('item-description') ?>"><?php echo html_escape($product->details) ?></textarea>
        </td>
        <td width="8%">
            <input type="text" class="form-control hsn" placeholder="" type="text" name="hsn[]">
        </td>
        <td width="8%">
            <input class="form-control qty ws-100" placeholder="Qty" type="text" name="quantity[]" value="1">
        </td>
        <td width="7%">
            <input type="text" class="form-control unit" placeholder="Box" type="text" name="unit[]">
        </td>
        <td width="8%">
            <input class="form-control price invo" placeholder="Price" type="text" name="price[]" value="<?php echo html_escape($product->price) ?>">
        </td>
        <td width="14%">
            <select class="form-control tax_id" data-id="<?php echo $product->id ?>" id="tax_id_<?php echo $product->id ?>" name="taxes[]">
                <option value="0"><?php echo trans('select-tax') ?></option>
            <?php foreach ($gsts as $gst): ?>   
                <optgroup label="<?php echo $gst->name ?>"> 
                <?php foreach ($gst->taxes as $tax): ?>
                <option value="<?php echo html_escape($tax->id) ?>"><?php echo html_escape($tax->name) ?> - <?php echo html_escape($tax->rate) ?>%</option>
                <?php endforeach ?>
                </optgroup>
            <?php endforeach ?>
            </select>  
            <input type="hidden" class="tax" id="tax_<?php echo $product->id ?>" value="<?php echo html_escape($product->tax) ?>" name="tax[]">
            <input type="hidden" class="tax_name" id="tax_name_<?php echo $product->id ?>" value="<?php echo html_escape($product->tax_type) ?>" name="tax_name[]">
        </td>
        <td width="15%">
            <div class="delete-btn">
                <span class="currency_wrapper"></span>
                <span class="total"><?php echo price_formatted_only($product->price, $this->business->id) ?></span>
                <a class="delete" href="javascript:;" title="Remove row">&times;</a>
                <input type="hidden" class="total" name="total_price[]" value="<?php echo html_escape($product->price) ?>">
                <input type="hidden" name="product_ids[]" value="<?php echo html_escape($product->id) ?>">
            </div>
        </td>
    </tr>
