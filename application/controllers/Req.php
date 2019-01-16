<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Req extends CI_Controller {


// Verification controller...................................................................................
	function index(){
		$this->load->helper('string');
		// load modal
		$this->load->model('Mreq');
		// if email and password are gotten
		if(isset($_POST['email']) && isset($_POST['password']) ){
			// save in variable
			$inputEmail = $_POST['email'];
			$inputPassword = $_POST['password'];
	        // email validation
			$inputEmail = trim($inputEmail);
			$inputEmail = stripslashes($inputEmail);
			$inputEmail = htmlspecialchars($inputEmail);
			// check if email is a sankore email
			$sankoreCheck = strpos($inputEmail, "@sankore.com");
			if ($sankoreCheck != false ){
				// get email data from DB
				$emailData = $this->Mreq->email();
				$resultSet = $emailData->result_array();
				// check if inputEmaiil is in DB
				foreach ($resultSet as $row) {
					// check DB data if the email exist
					if ($inputEmail == $row['Email']) {
						// get password when email exists
						$gotPassword = $this->Mreq->getPassword($inputEmail);
						$gotPassword = $gotPassword->result_array()[0]['Password'];
						// password validation
						$inputPassword = trim($inputPassword);
						$inputPassword = stripslashes($inputPassword);
						$inputPassword = htmlspecialchars($inputPassword);
						//  check if passwords are same
						if ($inputPassword == $gotPassword) {
							// get activation Status
							$actStat = $this->Mreq->activationStat($inputEmail);
							$actStat = $actStat->result_array()[0]['Activated'];
							// check activation status
							if ($actStat == "yes") {
								// if its activated set login status to on
								$_SESSION['loginStatus'] = 'on';
								// create a rand string as a session tag
								$tag = random_string('md5', 16);
								// echo $tag;
								// cxreate sesion for emailaddress
								$_SESSION[$tag] = $inputEmail ;
								// set cookie
								set_cookie('sankoreR',$tag,'3600');
								// if its activated login redirect to present url
								// set present url
								if(isset($_SESSION['presentUrl'])){
									// set unique id session as empty;
									$_SESSION['uniqueid'] = "off" ;
									redirect($_SESSION['presentUrl']);
								}else{
									$_SESSION['presentUrl'] = base_url().'/Req/dashboard';
									redirect($_SESSION['presentUrl']);
								}
								echo '
								<script> console.log('.$_SESSION[$tag].') 
								</script>';
							}else{
								echo ("not activated");
								// $this->load->view('login');
								// redirect(base_url().'/Req/index');
								redirect(base_url().'Req/login');
							}
						}else{
							echo ("wrong password"."<br>");
							// $this->load->view('login');;
							// redirect(base_url().'/Req/index');
							redirect(base_url().'Req/login');
						}
					}
					// else{
					// 	echo ("email does not exist");
					// 	// $this->load->view('login');
					// 	// redirect(base_url().'/Req/index');
					// 	// redirect(base_url().'Req/login');
					// }
				}
				// end of for loop
			}else{
				echo ("wrong email Address"."<br>");
				// $this->load->view('login');
				// redirect(base_url().'/Req/index');
				redirect(base_url().'Req/login');
			}
		}else{
			// $this->load->view('login');
			echo ("no username or password");
			echo('
				<script> console.log("no username or password") 
				</script>'
			);
			redirect(base_url().'Req/login');
		}
	}

// login controller.........................................................................................
	function login(){
		// set present url
		// $_SESSION['presentUrl'] = base_url().'/Req/dashboard';
		// load login view
		$this->load->view('login');
	}

// dashboard controller.........................................................................................
	function dashboard(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('dashboard');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// signed controller .............................................................................................
	function signed(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load modal
						$this->load->model('Mreq');
						// get list of pipes in use from DB
						$pipeInuse = $this->Mreq->pipeinuse();
						// get list of pipes not in use from DB
						$pipeNotinuse = $this->Mreq->pipeNotinuse();
						// uploded by is email of logged in user 
						$uploadedby = $_SESSION[$cookieValue];
						// get from getupload modal to render from upload DB to just uploads table
    					$getupload = $this->Mreq->getupload($uploadedby);
    					// get users to send to and render it from reg table 
    					$getuserinfo = $this->Mreq->getuserinfo();
						// creating array to send to frontend
						$details = array('pipeinuse' => $pipeInuse, 'pipenotinuse' => $pipeNotinuse, 'email' => $_SESSION[$cookieValue], 'getupload' => $getupload, 'getuserinfo' =>$getuserinfo);
						// load views and attached data from table
						$this->load->view('header');
						$this->load->view('signed', $details);
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// profile controller.........................................................................................
	function profile(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('profile');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// register controller.............................................................................................
	function register(){
		// log registration view
		$this->load->view('register');
	}

// history controller..............................................................................................
	function history(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load history view
						$this->load->view('header');
						$this->load->view('history');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// received controller.........................................................................................
	function received(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('received');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// process controller.........................................................................................
	function process(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('process');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// template controller.........................................................................................
	function template(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('template');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// sent controller.........................................................................................
	function sent(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load modal
						$this->load->model('Mreq');
						// sets who has the sent view
						$sentby = $_SESSION[$cookieValue];
						// get details from sent table on DB
						$senttable = $this->Mreq->senttable($sentby);
						$details = array('senttable' => $senttable);
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('sent', $details);
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// declined controller.........................................................................................
	function declined(){
		// set present url
		if(isset($_SESSION['presentUrl'])){
			$_SESSION['presentUrl'] = current_url();
		}else{
			$_SESSION['presentUrl'] = current_url();
		}
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load the dashboard view
						$this->load->view('header');
						$this->load->view('declined');
						$this->load->view('footer');
					}else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// logout controller.........................................................................................
	function logout(){
		// get cookie
		$cookieValue = get_cookie('sankoreR');
		// kill ci OG session
		$_SESSION[$cookieValue] = 'off';
		// set login status to off
		$_SESSION['loginStatus'] = 'off';
		// set unique id of just uploaded table in view to off
		$_SESSION['uniqueid'] = 'off';
		// delete cookie
		delete_cookie('sankoreR');
		// session_destroy();
		$this->session->sess_destroy();
		// redirect to validation controller
		redirect(base_url().'/Req/index');
	}

// ...................... controllers that do not load pages just workers ............................................................................................................
// .........................................................................................................................................................................

// new form upload controller.....................................................................................
	function jupload(){
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
						// load modal
						$this->load->model('Mreq');
						// load string helper
						$this->load->helper('string');
						// load date helper
						$this->load->helper('date');
						// get pip name from form
						$pipename = $_POST['pipe'];
						// get email 
						$creator = $uploadedby = $_SESSION[$cookieValue];
						// $_POST['uemail'];
						// create unique id
						$uniqueid = random_string('md5',16);
						// date
						$datestring1 = '%Y/%m/%d';
						// time
						$datestring2 = '%h:%i %a';
						$time = time();
						$date = mdate($datestring1, $time);
						$time = mdate($datestring2, $time);
						// pdf uploader
						$config['upload_path']          = './pdf/jupload/';
						$config['detect_mime']        	= TRUE;
						$config['file_ext_tolower']		= TRUE;
						$config['remove_spaces']		= TRUE;
				        $config['allowed_types']        = 'pdf';
				        $config['max_size']             = 6000;
				        $this->load->library('upload', $config);
				        // if upload fails
				        if ( ! $this->upload->do_upload('spdf'))
							{
								echo ($this->upload->display_errors());
				        }
				        // if upload works
				        else
				    		{	
				    			// update pipe in use on DB
								$this->Mreq->upipeinuse($pipename);
		            				 		$data1 = $this->upload->data('raw_name');
							            	$data2 = $this->upload->data('full_path');
				            	$formname = $data3 = $this->upload->data('file_name');
							            	$data4 = $this->upload->data('file_path');
							    // send to upload model
				            	$this->Mreq->upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator);
				            	// reload signed page
				            	redirect(base_url().'/Req/signed');
				        }
			        }else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// existing form upload controller.....................................................................................
	function eupload(){
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
					// load modal
					$this->load->model('Mreq');
					// load string helper
					$this->load->helper('string');
					// load date helper
					$this->load->helper('date');
					// get pip name from form
					$pipename = $_POST['pipe'];
					// get email 
					$creator = $uploadedby = $_POST['uemail'];
					// create unique id
					$uniqueid = random_string('md5',16);
					// date
					$datestring1 = '%Y/%m/%d';
					// time
					$datestring2 = '%h:%i %a';
					$time = time();
					$date = mdate($datestring1, $time);
					$time = mdate($datestring2, $time);
					// pdf uploader
					$config['upload_path']          = './pdf/jupload/';
					$config['detect_mime']        	= TRUE;
					$config['file_ext_tolower']		= TRUE;
					$config['remove_spaces']		= TRUE;
			        $config['allowed_types']        = 'pdf';
			        $config['max_size']             = 6000;
			        $this->load->library('upload', $config);
			        // if upload fails
			        if ( ! $this->upload->do_upload('spdf'))
						{
							echo ($this->upload->display_errors());
			        }
			        // if upload works
			        else
			    		{
			            	$formname = $data1 = $this->upload->data('raw_name');
						            	$data2 = $this->upload->data('full_path');
						            	$data3 = $this->upload->data('file_name');
						            	$data4 = $this->upload->data('file_path');
						    // send to upload model
			            	$this->Mreq->upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator);
			            	// reload signed page
			            	redirect(base_url().'/Req/signed', $error);
			        }
		        }else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// close form upload controller.....................................................................................
	function cupload(){
		// check login status
		if(isset($_SESSION['loginStatus'])){
			if($_SESSION['loginStatus'] == "on"){
				// check if cookie is set
				if(isset($_COOKIE['sankoreR'])){
					// get cookie value
					$cookieValue = get_cookie('sankoreR');
					// check if session is set
					if(isset($_SESSION[$cookieValue])){
					// load modal
					$this->load->model('Mreq');
					// load string helper
					$this->load->helper('string');
					// load date helper
					$this->load->helper('date');
					// get pip name from form
					$pipename = $_POST['pipe'];
					// get email 
					$creator = $uploadedby = $_POST['uemail'];
					// create unique id
					$uniqueid = random_string('md5',16);
					// date
					$datestring1 = '%Y/%m/%d';
					// time
					$datestring2 = '%h:%i %a';
					$time = time();
					$date = mdate($datestring1, $time);
					$time = mdate($datestring2, $time);
					// pdf uploader
					$config['upload_path']          = './pdf/jupload/';
					$config['detect_mime']        	= TRUE;
					$config['file_ext_tolower']		= TRUE;
					$config['remove_spaces']		= TRUE;
			        $config['allowed_types']        = 'pdf';
			        $config['max_size']             = 6000;
			        $this->load->library('upload', $config);
			        // if upload fails
			        if ( ! $this->upload->do_upload('spdf'))
						{
							echo ($this->upload->display_errors());
			        }
			        // if upload works
			        else
			    		{
			            	$formname = $data1 = $this->upload->data('raw_name');
						            	$data2 = $this->upload->data('full_path');
						            	$data3 = $this->upload->data('file_name');
						            	$data4 = $this->upload->data('file_path');
						    // send to upload model
			            	$this->Mreq->upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator);
			            	// reload signed page
			            	redirect(base_url().'/Req/signed', $error);
			        }
		        }else{
						echo "session email not set";
						$this->load->view('login');
					}
				}else{
					echo "cookie not set";
					$this->load->view('login');
				}
			}else{
				echo "loginstatus is off";
				$this->load->view('login');
			}	
		}else{
			echo "loginstatus not set";
			$this->load->view('login');
		}
	}

// get unique id from view and throw it here to the controller
	function senduid(){
		$uniqueid = $_POST['uniqueid'];
		$_SESSION['uniqueid'] = $uniqueid;
		echo($uniqueid);
	}

// get who form is been sent to and update sent table
	function sendtosend(){
		// get email to send info to
		$emailtosend = $_POST['emailtosend'];
		// echo($email);
		// echo($_SESSION['uniqueid']);
		// load modal
		$this->load->model('Mreq');
		// load date helper
		$this->load->helper('date');
		// date
		$datestring1 = '%Y/%m/%d';
		// time
		$datestring2 = '%h:%i %a';
		$time = time();
		$date = mdate($datestring1, $time);
		$time = mdate($datestring2, $time);
		// get cookie value
		$cookieValue = get_cookie('sankoreR');
		// uploded by is email of logged in user 
		$sentby = $fromwho = $uploadedby = $_SESSION[$cookieValue];
		// who its been sent to 
		$sentto = $towho = $emailtosend;
		// unique id
		$uniqueid = $_SESSION['uniqueid'];
		// status init is pending
		$status = 'pending';
		// get the rest
		$therest = $this->Mreq->getformdetails($uniqueid, $uploadedby);
		$pipename = $therest->result_array()[0]['PipeName'];
		$formname = $therest->result_array()[0]['FormName'];
		$creator = $therest->result_array()[0]['Creator'];
		if ($pipename != "" && $formname!= "" && $creator != ""){
			// send to sent DB
			$this->Mreq->intosend($formname, $date, $time, $pipename, $uniqueid, $sentto, $sentby, $creator, $status);
			// update pipe name table with details
			$this->Mreq->intounpipe($pipename, $creator, $fromwho, $towho, $uniqueid, $status);
			// delete sent form from the upload table
			$this->Mreq->deletefupload($uniqueid, $uploadedby);
			// reload signed page
	    	// redirect(base_url().'/Req/signed');
			// turn off unique id of form sent
			$_SESSION['uniqueid'] = 'off';
			echo("success");
		}else{
			echo "failed";
			// reload signed page
    		redirect(base_url().'/Req/signed');
			
		}
	}

// delete from upload table on view controller
	function deleteupload(){
		// load modal
		$this->load->model('Mreq');
		// get uniqueid 
		$uniqueid = $_SESSION['uniqueid'];
		// get cookie value
		$cookieValue = get_cookie('sankoreR');
		// uploded by is email of logged in user 
		$uploadedby = $_SESSION[$cookieValue];
		// get ppipe name
		$details = $this->Mreq->getpipeformname($uniqueid, $uploadedby);
		$pipename = $details->result_array()[0]['PipeName'];
		$formname = $details->result_array()[0]['FormName'];
		if ($uniqueid != "" && $uploadedby != "" && $pipename != ""){
			// delete pdf from uploads directory
			$deletepdf = unlink('pdf/jupload/'.$formname);
			if($deletepdf){
				// update pipe in use on DB
				$this->Mreq->upipenotinuse($pipename);
				// delete sent form from the upload table
				$this->Mreq->deletefupload($uniqueid, $uploadedby);
				// reload signed page
	    		// redirect(base_url().'/Req/signed');
			    // turn off unique id of form sent
				$_SESSION['uniqueid'] = 'off';
				echo("success");
			}else{
				echo("error deleting file");
				// reload signed page
	    		redirect(base_url().'/Req/signed');
			}
		}else{
			echo "failed to get details";
			// reload signed page
	    	redirect(base_url().'/Req/signed');
		}
	}

}
?>
