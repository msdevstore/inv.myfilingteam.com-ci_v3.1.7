<select class="form-control single_select" name="customer" id="vendors">
    <option value=""><?php echo trans('select-Vendor') ?></option>
    <?php foreach ($customers as $customer): ?>
      <option value="<?php echo html_escape($customer->id) ?>" <?php if($invoice[0]['customer'] == $customer->id || isset($select_customer) && $select_customer == $customer->id){echo "selected";} ?>
      ><?php echo html_escape($customer->name) ?></option>
    <?php endforeach ?>
</select>