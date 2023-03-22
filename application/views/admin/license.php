<div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <div class="row">
              <div class="col-md-8">
                <div class="card mt-4">
                  <div class="card-header border-0">
                    <h3 class="card-title">License Info</h3>
                  </div>
                 
                    <div class="card-body">
                        <?php if (get_user_info() == false): ?> 
                          <p class="text-md mb-2 mt-2">License type: <span class="text-info font-weight-bold"><i class="fa fa-check-circle"></i> Regular </span></p>

                          <?php if (get_user_info() == false): ?>
                            <p class="text-md mb-4">Payment Gateways: <span class="text-danger font-weight-bold"><i class="fa fa-times-circle"></i> Not available </span></p>
                          <?php endif ?>

                        <?php else: ?>
                          <p class="text-md mt-0 mt-3">License type: <span class="text-primary font-weight-bold"><i class="fa fa-check-circle"></i> Extended</span></p>
                        <?php endif ?>
                        
                        <?php if (get_user_info() == false): ?>
                          <p class="badge badge-success text-md font-weight-normal"><i class="fa fa-info-circle"></i> If you want to upgrade your license from regular to extended please send email to us </p>
                          <p><a class="btn btn-info" href="mailto:codericks.envato@gmail.com?subject=Support - Upgrade License"> Click to send email</a></p>
                        <?php endif ?>
                    </div>
                    
                </div>
              </div>
          </div>
      </div>
    </div>
</div>