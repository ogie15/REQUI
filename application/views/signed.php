<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Signed Forms
        <small></small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- create pipe -->
      <div class="row">
        <!-- first column -->
       <div class="col-xs-12">
          <div class="box box-default collapsed-box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Upload to a New Chain</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">

              <!-- form start -->
              <form role="form" action="<?php echo(base_url()); ?>Req/jupload" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <label>Select Pipe</label>
                    <select name="pipe" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                      <!-- render values of free pipes -->
                      <?php
                      foreach ($pipenotinuse->result_array() as $row){
                        echo ('
                          <option id=pipen3>'.$row['PipeName'].'</option>
                        ');
                      }
                      ?>
                      <!-- render values of free pipes -->
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Upload a PDF</label>
                    <input type="file" name="spdf" id="exampleInputFile">
                    <!-- <input type="hidden" name="uemail" value="<?php echo $email; ?>"> -->
                    <!-- <p class="help-block">Example block-level help text here.</p> -->
                  </div>
                </div>
                <!-- /.box-body -->
                <div id=checker3 class="box-footer">
                  <button id=check3 type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- form end -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (first) -->
      </div>
      <!-- /.row -->
      <!-- /.create pipe -->

      <!-- use existing pipe -->
      <div class="row">
        <!-- first column -->
        <div class="col-xs-12">
          <div class="box box-default collapsed-box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Upload to a Existing Chain</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
              
              <!-- form start -->
              <form role="form" action="<?php echo(base_url()); ?>Req/eupload" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <label>Select Pipe</label>
                    <select name="pipe" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                      <!-- render values of free pipes -->
                      <?php
                      foreach ($pipeinuse->result_array() as $row){
                        echo ('
                          <option id=pipen>'.$row['PipeName'].'</option>
                        ');
                      }
                      ?>
                      <!-- render values of free pipes -->
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Upload a PDF</label>
                    <input type="file" name="spdf" id="exampleInputFile">
                    <!-- <input type="hidden" name="uemail" value="<?php echo $email; ?>"> -->
                    <!-- <p class="help-block">Example block-level help text here.</p> -->
                  </div>
                </div>
                <!-- /.box-body -->
                <div id=checker class="box-footer">
                  <button id=check type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- form end -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (first) -->
      </div>
      <!-- /.row -->
      <!-- /.existing pipe -->

      <!-- use pipe to close -->
      <div class="row">
        <!-- first column -->
        <div class="col-xs-12">
          <div class="box box-default collapsed-box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Upload to Close</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="">
              
              <!-- form start -->
              <form role="form" action="<?php echo(base_url()); ?>Req/cupload" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <label>Select Pipe</label>
                    <select name="pipe" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                      <!-- render values of free pipes -->
                      <?php
                      foreach ($pipeinuse->result_array() as $row){
                        echo ('
                          <option id=pipen2>'.$row['PipeName'].'</option>
                        ');
                      }
                      ?>
                      <!-- render values of free pipes -->
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Upload a PDF</label>
                    <input type="file" name="spdf" id="exampleInputFile">
                    <!-- <input type="hidden" name="uemail" value="<?php echo $email; ?>"> -->
                    <!-- <p class="help-block">Example block-level help text here.</p> -->
                  </div>
                </div>
                <!-- /.box-body -->
                <div id=checker2 class="box-footer">
                  <button id=check2 type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- form end -->

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (first) -->
      </div>
      <!-- /.row -->
      <!-- /.use pipe to close-->

      <!-- just uploaded forms -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Just Uploaded Forms</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>SN</th>
                  <th>Name of Form</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Initiator</th>
                  <th>Pipe Name</th>
                  <th>Delete</th>
                  <th>Send</th>
                  <!-- <th>Download</th> -->
                </tr>
                <!-- rending view for just uploded forms -->
                <?php
                  foreach ($getupload->result_array() as $row){
                    echo ('
                      <tr> 
                        <td>'.$row['Id'].'</td>
                        <td>'.$row['FormName'].'</td>
                        <td>'.$row['Date'].'</td>
                        <td>'.$row['Time'].'</td>
                        <td>'.$row['Creator'].'</td>
                        <td><a href=""><span>'.$row['PipeName'].'</span></a></td>
                        <td><a href="" onclick="senduid('.'\''.$row['UniqueId'].'\''.')" type="button" class="btn btn-danger btn bg-maroon btn-sm" data-toggle="modal" data-target="#modal-danger"><span>Delete</span></a></td>
                        <td><a href="" onclick="senduid('.'\''.$row['UniqueId'].'\''.')" type="button" class="btn btn-success btn bg-olive  btn-sm" data-toggle="modal" data-target="#modal-success"><span>Send</span></a></td>
                        <!-- <td><a href=""><span class="btn bg-orange btn-sm">Download</span></a></td> -->  
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
      <!-- just uploaded forms -->

      <!-- modal for send -->
      <div class="modal modal-success fade" id="modal-success">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" style="color: #fff;">Send to</h4>
            </div>
            <div class="modal-body">

            <?php
              foreach ($getuserinfo->result_array() as $row){
                echo ('
                <div class="user-block" data-dismiss="modal">
                  <a href="#" onclick="sendtosend('.'\''.$row['Email'].'\''.')">
                    <img class="img-circle img-bordered-sm" src="'.base_url().'assets/dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username" style="color: #fff;">
                          '.$row['FirstName'].' '.$row['LastName'].'
                          <!-- <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> -->
                        </span>
                    <span class="description" style="color: #fff;">'.$row['Department'].'</span>
                    <span class="description" style="color: #fff;">'.$row['Email'].'</span>
                  </a>
                  <hr>
                </div>
                <!-- <p>One fine body&hellip;</p> -->
                ');
              }
            ?>
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button> -->
              <!-- <button type="button" class="btn btn-outline">Save changes</button> -->
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- /.modal for send -->

      <!-- modal for delete -->
      <div class="modal modal-danger fade" id="modal-danger">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Delete</h4>
            </div>
            <!-- <div class="modal-body"> -->
              <!-- <p>One fine body&hellip;</p> -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
              <button  type="button" class="btn btn-outline" onclick="deleteupload()">Yes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <!-- /.modal for delete -->
      
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper---->

  <!-- script to get unique id from each data echoed in the just uploaded table -->
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

    // collect who form is been sent to and updates sent table
    function sendtosend(emailtosend) {
      $.post("<?php echo(base_url()); ?>Req/sendtosend",
        {"emailtosend": emailtosend},
        function(data, status){
          alert("Data: " + data + "\nStatus: " + status);
          location.reload(true);
        }
      );
    }

    // delete form upload table
    function deleteupload(){
      $.post("<?php echo(base_url()); ?>Req/deleteupload",
        function(data, status){
          alert("Data: " + data + "\nStatus: " + status);
          location.reload(true);
        }
      );
      // location.reload(true);
    }

    
// help to disable submit button when not pipe is not available or pipe is not meant for current user EUPLOAD
    $("#check").on({
      mouseenter:
      // console.log("working");
      function(){
        let pipe = $("#pipen").text();
        if(pipe==""){
          $("#check").attr('disabled','disabled');
        }else{
          // ping disabler checker controller
          $.post("<?php echo(base_url()); ?>Req/cifitsforu",
            {"pipe": pipe},
            function(data, status){
              if(data == "NotValid" || data == "Empty"){
                $("#check").attr('disabled','disabled');
              }else{
                console.log(data);
              }
            }
          );
        }
      }
    });

// enables back the submit button FOR EUPLOAD
    $("#checker").on({
      mouseleave:
        function(){
          $("#check").removeAttr('disabled');
          console.log("leave");
        }
    });

// help to disable submit button when not pipe is not available or pipe is not meant for current user FOR CUPLOAD
    $("#check2").on({
      mouseenter:
      // console.log("working");
      function(){
        let pipe = $("#pipen2").text();
        if(pipe==""){
          $("#check2").attr('disabled','disabled');
        }else{
          // ping disabler checker controller
          $.post("<?php echo(base_url()); ?>Req/cifitsforu",
            {"pipe": pipe},
            function(data, status){
              if(data == "NotValid" || data == "Empty"){
                $("#check2").attr('disabled','disabled');
              }else{
                console.log(data);
              }
            }
          );
        }
      }
    });

// enables back the submit button FOR CUPLOAD
    $("#checker2").on({
      mouseleave:
        function(){
          $("#check2").removeAttr('disabled');
          console.log("leave");
        }
    });

    // help to disable submit button when not pipe is not available or pipe is not meant for current user FOR CUPLOAD
    $("#check3").on({
      mouseenter:
      // console.log("working");
      function(){
        let pipe = $("#pipen3").text();
        if(pipe==""){
          $("#check3").attr('disabled','disabled');
        }else{
        }
      }
    });

// enables back the submit button FOR CUPLOAD
    $("#checker3").on({
      mouseleave:
        function(){
          $("#check3").removeAttr('disabled');
          console.log("leave");
        }
    });

  </script>