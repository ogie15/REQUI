 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Received Forms
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
              <h3 class="box-title">Just Received Forms</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>SN</th>
                  <th>Name of Form</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Sent By</th>
                  <th>Initiator</th>
                  <th>Pipe Name</th>
                  <th>Decline</th>
                  <th>Download</th>
                  <th>Approve</th>

                </tr>
                <?php 
                foreach ($received->result_array() as $row) {   
                  if($row['Wtd'] == "C"){
                    echo('
                    <tr>
                      <td>'.$row['Id'].'</td>
                      <td>'.$row['FormName'].'</td>
                      <td>'.$row['Date'].'</td>
                      <td>'.$row['Time'].'</td>
                      <td>'.$row['SentBy'].'</td>
                      <td>'.$row['Creator'].'</td>
                      <td>'.$row['PipeName'].'</td>
                      <td><a href="" onclick="senduid('.'\''.$row['UniqueId'].'\''.')" type="button" class="btn btn-danger btn bg-maroon btn-sm" data-toggle="modal" data-target="#modal-danger"><span>Decline</span></a></td>
                      <td><button onclick="dLoad('.'\''.$row['FormName'].'\''.')" class="btn bg-orange btn-sm">Download</buttonn></td>
                      <td><a href="" onclick="senduid('.'\''.$row['UniqueId'].'\''.')" type="button" class="btn btn-success btn bg-olive  btn-sm" data-toggle="modal" data-target="#modal-success"><span id="appr">Approve & Close</span></a></td>
                    </tr>
                  '); 
                  }else{
                    echo('
                    <tr>
                      <td>'.$row['Id'].'</td>
                      <td>'.$row['FormName'].'</td>
                      <td>'.$row['Date'].'</td>
                      <td>'.$row['Time'].'</td>
                      <td>'.$row['SentBy'].'</td>
                      <td>'.$row['Creator'].'</td>
                      <td>'.$row['PipeName'].'</td>
                      <td><a href="" onclick="senduid('.'\''.$row['UniqueId'].'\''.')" type="button" class="btn btn-danger btn bg-maroon btn-sm" data-toggle="modal" data-target="#modal-danger"><span>Decline</span></a></td>
                      <td><button onclick="dLoad('.'\''.$row['FormName'].'\''.')" class="btn bg-orange btn-sm">Download</buttonn></td>
                      <td><a href="" onclick="senduid('.'\''.$row['UniqueId'].'\''.')" type="button" class="btn btn-success btn bg-olive  btn-sm" data-toggle="modal" data-target="#modal-success"><span id="appr">Approve</span></a></td>
                    </tr>
                    ');
                  }           
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

            <form name="myreason">
              <div class="box-body">
                <div class="form-group">
                  <label>Your Reason</label>
                  <textarea name="reason" class="form-control" rows="3" placeholder="Enter ..." style="margin: 0px 10.5px 0px 0px;"></textarea>
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button onclick="decliner()" type="button" class="btn btn-primary">Submit</button>
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


   <!-- modal for Approve -->
    <div class="modal modal-success fade" id="modal-success">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" style="color: #fff;">Approve</h4>
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
            <button onclick="approvestat()" type="button" class="btn btn-outline">Yes</button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- /.modal for Approve -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script>
    // collect and send unique id of form to be sent
    function senduid(uniqueid){
      $.post("<?php echo(base_url()); ?>Req/senduid",
        {"uniqueid": uniqueid},
        function(data, status){
          console.log("Data: " + data + "\nStatus: " + status);
        }
      );
    }

    // helps to ping and fire approve controller
    function approvestat(){
      $.post("<?php echo(base_url()); ?>Req/approvestat",
        // {"emailtosend": emailtosend},
        function(data, status){
          // if already approved
          if(data == 'Approved'){
            alert("You can't Approve this form, it has already been Approved by you!");
            // if already declined
          }else if (data == 'Declined'){
            alert("You can't Approve this form, it has already been Declined by you!");
          }else if(data == 'Finished'){
            alert("You can't Approve this form its been Completed & Closed");
          }else if(data == 'Done'){
            alert("Success");
            // location.reload(true);
          }
          console.log(data);
        }
      );
      
    }

    // download for received
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

    //get form details and send it to controller
    function decliner(){
      let reason = document.forms["myreason"]["reason"].value;
      // document.getElementById('cctextboxid').value
      if(reason.length != 0){
        console.log(reason);
        $.post("<?php echo(base_url()); ?>Req/declineform",
          {"reason": reason},
          function(data, status){
            // if already approved
            if(data == 'Approved'){
              alert("You can't Decline this form, it has already been Approved by you!");
              // if already declined
            }else if(data == 'Declined'){
              alert("You can't Decline this form, it has already been Declined by you!");
            }else if(data == 'Finished'){
              alert("You can't Decline this form its been Completed & Closed");
            }else if(data == 'Done'){
              alert("Success");
              location.reload(true);
            }
          }
        );
      }else{
        alert("U didn't indicate a reason sir...");
        console.log(reason.length + " reason entered");
        console.log("U didn't indicate a reason sir...");
      }
      
    }

    //change value of Approve in the green Box
      // $(function(){
      //   // get wtd value 
      //   $.get("<?php echo(base_url()); ?>Req/wtd", 
      //     function(data, status){
      //       // console.log(data + "\n" + status);
      //       if(data == "C"){
      //         // change value to ................
      //         $("#appr").text(function(i, origText){
      //           return "Approve & Close O!"
      //         });
      //       }else{
      //         console.log(data + "\n" + status);
      //       }
      //     }
      //   );
      // });
    

    // // delete form upload table
    // function deleteupload(){
    //   $.post("<?php echo(base_url()); ?>Req/deleteupload",
    //     function(data, status){
    //       alert("Data: " + data + "\nStatus: " + status);
    //       location.reload(true);
    //     }
    //   );
    //   // location.reload(true);
    // }

  </script>