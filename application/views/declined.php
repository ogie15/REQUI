 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Declined Forms
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
                  <th>Declined By</th>
                  <th>Initiator</th>
                  <th>Pipe Name</th>
                  <th>Reason</th>
                  

                </tr>
                <?php
                  foreach ($getdeclined->result_array() as $row) {
                    echo('
                    <tr>
                      <td>'.$row['Id'].'</td>
                      <td>'.$row['FormName'].'</td>
                      <td>'.$row['Date'].'</td>
                      <td>'.$row['Time'].'</td>
                      <td>'.$row['DeclinedBy'].'</td>
                      <td>'.$row['Creator'].'</td>
                      <td>'.$row['PipeName'].'</td>
                      <td>'.$row['Reason'].'</td>
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


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->