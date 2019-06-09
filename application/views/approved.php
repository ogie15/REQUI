 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approved Forms
        <small></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Sent Forms</h3> -->
              Approved Forms
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>SN</th>
                  <th>Name of Form</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Pipe Name</th>
                  <th>Sent By</th>
                  <th>Initiator</th>
                  <th>Download</th>
                </tr>
                <!-- rending view for just uploded forms -->
                <?php
                  foreach ($approved->result_array() as $row){
                    echo ('
                      <tr>
                        <td>'.$row['Id'].'</td>
                        <td>'.$row['FormName'].'</td>
                        <td>'.$row['Date'].'</td>
                        <td>'.$row['Time'].'</td>
                        <td>'.$row['PipeName'].'</td>
                        <td>'.$row['SentBy'].'</td>
                        <td>'.$row['Creator'].'</td>
                        <td><button onclick="dLoad('.'\''.$row['FormName'].'\''.')" class="btn bg-orange btn-sm">Download</buttonn></td>
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
    // download for approved
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