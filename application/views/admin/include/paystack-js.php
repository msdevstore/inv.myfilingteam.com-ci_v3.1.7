
<script>
  <?php if (isset($paystack_type) && $paystack_type == 'user'): ?>
    function payWithPaystack(){
      var handler = PaystackPop.setup({
        key: '<?php echo $user->paystack_public_key; ?>',
        email: '<?php echo $email; ?>',
        amount: '<?php echo $price * 100; ?>',
        currency: '<?php echo $currency_code ?>',
        ref: ''+Math.floor((Math.random() * 1000000000) + 1), 
        callback: function(response){
            window.location.href = `<?php echo base_url().'paystack/verify_customer_payment/' ?>${response.reference}/<?php echo $invoice->id; ?>/<?php echo $amount; ?>`;                    
        },
        onClose: function(){
            alert('window closed');
        }
      });
      handler.openIframe();
    }
  <?php else: ?>
    function payWithPaystack(){
      var handler = PaystackPop.setup({
        key: '<?php echo settings()->paystack_public_key; ?>',
        email: '<?php echo user()->email; ?>',
        amount: '<?php echo $price * 100; ?>',
        currency: '<?php echo settings()->currency ?>',
        ref: ''+Math.floor((Math.random() * 1000000000) + 1), 
        callback: function(response){
            window.location.href = `<?php echo base_url().'paystack/verify_payment/' ?>${response.reference}/<?php echo $billing_type; ?>/<?php echo $package->id; ?>`;                    
        },
        onClose: function(){
            alert('window closed');
        }
      });
      handler.openIframe();
    }
  <?php endif ?>
</script>