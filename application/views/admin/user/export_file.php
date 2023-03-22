<!DOCTYPE html>
<html lang="en">
<head>

<link rel="icon" href="<?php echo base_url($settings->favicon) ?>">

<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css">
<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-extend.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/admin_style.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/skins/_all-skins.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css2?family=Alata:wght@400;500;700&display=swap" rel="stylesheet" />
<style>
    body{
        font-family: "Alata", sans-serif;
    }
</style>
</head>

<body>

    <?php $currency_symbol = helper_get_customer($invoice->customer)->currency_symbol ?>
    <div class="content-wrappers">
        <section class="content p-0">
            <?php if (isset($mode) && $mode == 'preview'): ?>
                <div class="preview-mood-top p-20 text-center extract-title">
                    <a href="#" class="btn btn-default btn-rounded mr-5 disabled"><i class="fa fa-eye"></i> <?php echo trans('preview-mode') ?> </a>

                    <?php if (isset($link) && $link != ''): ?>
                        <a href="<?php echo $link ?>" class="btn btn-default btn-rounded mr-5"><i class="fa fa-long-arrow-left"></i> <?php echo trans('back') ?> </a>
                    <?php endif ?>
                    <p class="mt-10 c-1038"><i class="fa fa-info-circle"></i> <?php echo trans('preview-mode-msg') ?></p>
                </div>
            <?php endif ?>

            <div class="container" style="padding: 0px">
                <div class="col-md-12" style="padding: 0px">
                    <div id="invoice_save_area m-0" class="cards inv save_area print_area" style="padding: 0px">
                        <?php include"include/invoice_export_style.php"; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <footer></footer>
<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/admin/js/jquery3.min.js"></script>
<!-- popper -->
<script src="<?php echo base_url() ?>assets/admin/js/popper.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap.min.js"></script>
</body>
</html>