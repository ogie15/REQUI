 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sent Forms
        <small></small>
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Sent Forms</h3> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>SN</th>
                  <th>Name of Form</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Sent To</th>
                  <th>Initiator</th>
                  <th>Pipe Name</th>
                  <th>Status</th>
                </tr>
                <!-- rending view for just uploded forms -->
                <?php
                  foreach ($senttable->result_array() as $row){
                    echo ('
                      <tr>
                        <td>'.$row['Id'].'</td>
                        <td>'.$row['FormName'].'</td>
                        <td>'.$row['Date'].'</td>
                        <td>'.$row['Time'].'</td>
                        <td>'.$row['SentTo'].'</td>
                        <td>'.$row['Creator'].'</td>
                        <td>'.$row['PipeName'].'</td>
                        <td><a href="" type="button" class="btn btn-success btn bg-olive  btn-sm" data-toggle="modal" data-target="#modal-success"><span>'.$row['Status'].'</span></a></td>
                      </tr>
                    ');
                  }
                ?>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <!-- modal for Decline -->
      <div class="modal modal-danger fade" id="modal-danger">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Decline</h4>
            </div>

            <form role="form">
              <div class="box-body">
                <div class="form-group">
                  <label>Textarea</label>
                  <textarea class="form-control" rows="3" placeholder="Enter ..." style="margin: 0px 10.5px 0px 0px;"></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
            <!-- <div class="modal-body" style="background-color: red;"> -->
              <!-- <p>Are You Sure ?&hellip;</p> -->
          <!-- </div> -->
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
              <button type="button" class="btn btn-outline">Yes</button>
            </div> -->
        </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- /.modal for Decline -->


   <!-- modal for Status -->
    <div class="modal modal-success fade" id="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" style="color: #fff;">Status</h4>
          </div>
          <div class="modal-body">

            <!-- <div class="user-block">
              <a href="#">
                <img class="img-circle img-bordered-sm" src="<?php echo(base_url()); ?>assets/dist/img/user1-128x128.jpg" alt="user image">
                    <span class="username" style="color: #fff;">
                      Okougbo Esemuede
                      <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                    </span>
                <span class="description" style="color: #fff;">Technology</span>
                <span class="description" style="color: #fff;">ogie@sankore.com</span>
              </a>
              <hr>
            </div> -->
            <!-- <p>One fine body&hellip;</p> -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-outline">Yes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.modal for Status -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->