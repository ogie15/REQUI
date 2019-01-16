<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>

    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row" style="padding-bottom:30px;">
        <a href="<?php echo(base_url()); ?>Req/template">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>Get</h3>

                <p>Template</p>
              </div>
              <div class="icon">
                <i class="ion ion ion-code-download"></i>
              </div>
            </div>
          </div>
        </a>
          <!-- ./col -->
        <a href="<?php echo(base_url()); ?>Req/signed">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
              <div class="inner">
                <h3>Signed <sup style="font-size: 20px"></sup></h3>

                <p>Requistion Form</p>
              </div>
              <div class="icon">
                <i class="ion-android-done-all"></i>
              </div>
            </div>
          </div>
        </a>
          <!-- ./col -->
        <a href="<?php echo(base_url()); ?>Req/received">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
              <div class="inner">
                <h3>Recieved</h3>

                <p>Requistion Form</p>
              </div>
              <div class="icon">
                <i class="ion ion-arrow-graph-down-left"></i>
              </div>
            </div>
          </div>
        </a>
          <!-- ./col -->
        <a href="<?php echo(base_url()); ?>Req/history">
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
              <div class="inner">
                <h3>History</h3>

                <p>Of All Signed Forms</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-time-outline"></i>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="row" style="padding-bottom:30px;">
         <!-- ./col -->
        <a href="<?php echo(base_url()); ?>Req/sent">
          <div class="col-lg-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-teal">
              <div class="inner">
                <h3>Sent</h3>

                <p>Forms</p>
              </div>
              <div class="icon">
                <i class="ion ion-paper-airplane"></i>
              </div>
            </div>
          </div>
        </a>

         <!-- ./col -->
        <a href="<?php echo(base_url()); ?>Req/declined">
          <div class="col-lg-6 col-xs-12">
            <!-- small box -->
            <div class="small-box bg-navy">
              <div class="inner">
                <h3>Declined</h3>

                <p>Forms</p>
              </div>
              <div class="icon">
                <i class="ion-backspace-outline"></i>
              </div>
            </div>
          </div>
        </a>
      </div>
        <!-- ./col -->
    </section>
    <!-- /.content -->
    
  </div>
  <!-- /.content-wrapper -->