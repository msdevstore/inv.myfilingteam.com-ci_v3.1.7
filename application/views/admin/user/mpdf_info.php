<!DOCTYPE html>
<html lang="en">
<head>

<link rel="icon" href="<?php echo base_url($settings->favicon) ?>">
<title><?php echo html_escape($settings->site_name); ?> - <?php if(isset($page_title)){echo html_escape($page_title);}else{echo "Dashboard";} ?></title>
<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap.min.css">
<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/bootstrap-extend.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/master_style.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/skins/_all-skins.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/css/font-awesome.min.css">
</head>

<body style="font-weight: 400">

    <div class="content-wrappers mt-50">
        <section class="content p-0">
            <div class="containers">
                <div class="col-md-8 m-auto">
                    <div class="row mb-10">
                        <div class="col-md-12 text-center">
                            <div class="alert alert-info mt-300">
                                <div class="col-md-12 text-center">
                                    <h2 class="text-error mb-2 text-primary"><i class="fa fa-info-circle"></i> Attention</h2><br>
                                    <h6 class="mt-2">You need to add <b>mPDF</b> library in your project, please follow the direction below.</h6>
                                    <p>
                                        Download mpdfs.zip file here: <b><a href="http://accufy.originlabsoft.com/files/downloads/mpdfs.zip" class="text-primary"><i class="fa fa-cloud-download"></i> Download mPDF</a></b> and upload this zip file in your <strong class="text-primary" style="text-decoration: underline;">(project root folder > "vendor") </strong> inside this folder and extract it.
                                    </p><br>
                                </div>
                            </div>
                            <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="btn btn-default m-auto"> <i class="flaticon-left-arrow" aria-hidden="true"></i><i class="fa fa-long-arrow-left"></i> <?php echo trans('back') ?> </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <footer></footer>
<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/admin/js/jquery3.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo base_url() ?>assets/admin/js/bootstrap.min.js"></script>
</body>
</html>