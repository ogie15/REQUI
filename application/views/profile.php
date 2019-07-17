 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
      </h1>
      <!-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">User profile</li>
      </ol> -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

        <div class="col-md-12">

          <!-- Profile Image -->
          <div class="box box-primary">
          <?php  
          foreach ($profile->result_array() as $row){
            echo('
            <div class="box-body box-profile">
             
              
            <form role="form" action="'.base_url().'Req/picture" method="post" enctype="multipart/form-data">
              <a href="#">
                <input type="file" name="spic" id="uploader1" style="display:none"/>
                <img onclick=uploader2() class="profile-user-img img-responsive img-circle" src="'.base_url().'pdf/ppicture/'.$row['ProfilePic'].'" alt="User profile picture"> 
                <button id="sender" type="submit" style="display:none"> </button>
              </a>
            </form> 
              

              <h3 class="profile-username text-center">'.$row['FirstName'].' '.$row['LastName'].'</h3>

              <p class="text-muted text-center">'.$row['Department'].'</p>
              <p class="text-muted text-center">'.'ID '.$row['IdNum'].'</p>

              <!-- /.box-header -->
              <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i>Team</strong>

                <p class="text-muted">
                  '.$row['Team'].'
                </p>

                <!-- <hr> -->

               <!--  <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>
 -->
<!--                 <hr>

                <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

                <p>
                  <span class="label label-danger">UI Design</span>
                  <span class="label label-success">Coding</span>
                  <span class="label label-info">Javascript</span>
                  <span class="label label-warning">PHP</span>
                  <span class="label label-primary">Node.js</span>
                </p> -->

                <hr>

                <!-- <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p> -->
              </div>
              <!-- /.box-body -->
              ');
            }
            ?>
              <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>

<script>
  function uploader2()
  {
    document.getElementById("uploader1").click();
    console.log("working2");
  }
  document.getElementById("uploader1").addEventListener(
    "change", function(){
      if(document.getElementById("uploader1").value)
      {
        document.getElementById("sender").click();
        console.log("working");
      }
    }
  );
  


</script>