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
                  <th>Download</th>
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
                        <td><button onclick="dLoad('.'\''.$row['FormName'].'\''.')" class="btn bg-orange btn-sm">Download</buttonn></td>
                        <td><span class="btn bg-olive btn-sm">'.$row['Status'].'</span></td>
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

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    // download for sent
    function dLoad(formname){
      let dformname = formname;
      if(dformname != ' '){
        // reload to download page
        window.open("<?php echo(base_url()); ?>Req/dLoad?formname="+dformname);
        // console the formname
        console.log(dformname);
      }else{
        alert("Error : File is Invalid");
      }
    }
  </script>