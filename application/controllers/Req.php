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
				$emailData = $this->Mreq->email($inputEmail);
				// print_r($emailData);
				// // check if inputEmaiil is in DB
				// foreach ($resultSet as $row) {
					// check DB data if the email exist
					if ($emailData->num_rows() != 0) {
						$resultSet = $emailData->result_array()[0]['Email'];
						$inputEmail = $resultSet;
						// echo ($resultSet);
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
								// create sesion for emailaddress
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
								// redirect(base_url().'Req/login');
							}
						}else{
							echo ("wrong password"."<br>");
							// $this->load->view('login');;
							// redirect(base_url().'/Req/index');
							// redirect(base_url().'Req/login');
						}
					}
					else{
						echo ("email does not exist");
						// $this->load->view('login');
						// redirect(base_url().'/Req/index');
						// redirect(base_url().'Req/login');
					}
				// }
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
						// load modal
						$this->load->model('Mreq');
						// set email address
						$email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
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
						$uploadedby = $email = $_SESSION[$cookieValue];
						// get from getupload modal to render from upload DB to just uploads table
    					$getupload = $this->Mreq->getupload($uploadedby);
    					// get users to send to and render it from reg table 
    					$getuserinfo = $this->Mreq->getuserinfo($email);
						// creating array to send to frontend
						$details = array('pipeinuse' => $pipeInuse, 'pipenotinuse' => $pipeNotinuse, 'email' => $_SESSION[$cookieValue], 'getupload' => $getupload, 'getuserinfo' =>$getuserinfo);
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load views and attached data from table
						$this->load->view('header', $profiledetails);
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
						//load model
						$this->load->model('Mreq');
						// set email address
						$email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
						$this->load->view('profile', $profiledetails);
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

// approved controller..............................................................................................
	function approved(){
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
						// set received by to be user email
						$receivedby = $_SESSION[$cookieValue];
						// get approved data from DB
						$approved = $this->Mreq->approved($receivedby);
						$details = array('approved' => $approved);
						// set email address
						$email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load approved view
						$this->load->view('header', $profiledetails);
						$this->load->view('approved', $details);
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
						// load modal
						$this->load->model('Mreq');
						// sets who has the received form and email address
						$receivedby = $email= $_SESSION[$cookieValue];
						// get received data of form from DB
						$received = $this->Mreq->getreceived($receivedby);
						$received = array('received' => $received);
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
						$this->load->view('received', $received);
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
						//load model
						$this->load->model('Mreq');
						// set email address
						$email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
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
						//load model
						$this->load->model('Mreq');
						// set email address
						$email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
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
						// set email address
						$email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
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
						//load model
						$this->load->model('Mreq');
						// set email address
						$declinedby = $email = $_SESSION[$cookieValue];
						//get profile details
						$profile = $this->Mreq->profile($email);
						// turn profile details into array
						$profiledetails = array('profile' => $profile);
						// get declined details
						$getdeclined = $this->Mreq->getdeclined($declinedby);
						// turn declined details into array
						$details = array('getdeclined' => $getdeclined);
						// load the dashboard view
						$this->load->view('header', $profiledetails);
						$this->load->view('declined', $details);
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
						// WTD (what to do)
						$wtd = "N";
						// get email 
						$creator = $uploadedby = $_SESSION[$cookieValue];
						// $_POST['uemail'];
						// create unique id
						$uniqueid = random_string('md5',16);
						// set track
						$track = random_string('md5',22);
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
				        $config['max_size']             = 60000;
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
				            	$this->Mreq->upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator, $wtd, $track);
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
						// get pip name from form
						$pipename = $_POST['pipe'];
						// get data to know if pipe belongs to you
						$ifitsforu = $this->Mreq->ifitsforu($pipename);
						if(isset($ifitsforu->result_array()[0]['ToWho'])){
							$answer = $ifitsforu->result_array()[0]['ToWho'];
							if ($answer==$_SESSION[$cookieValue]){
								// echo "yes";
								// load string helper
								$this->load->helper('string');
								// load date helper
								$this->load->helper('date');
								// WTD (what to do)
								$wtd = "E";
								// uploded by
								$uploadedby = $towho = $_SESSION[$cookieValue];
								// get creator
								$ccreator = $this->Mreq->getunpipe($pipename, $towho);
								$creator = $ccreator->result_array()[0]['Creator'];
								// create unique id
								$uniqueid = random_string('md5',16);
								// set track
								$track = $ccreator->result_array()[0]['Track'];
								echo $track;
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
										$config['max_size']             = 60000;
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
											$this->Mreq->upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator, $wtd, $track);
											// reload signed page
											redirect(base_url().'/Req/signed');
										}
							}else{
								echo("Not meant for you");
								// reload signed page
								// redirect(base_url().'/Req/signed');
							}
						}else{
							echo("Custom Error Empty");
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
						// get pip name from form
						$pipename = $_POST['pipe'];
						// get data to know if pipe belongs to you
						$ifitsforu = $this->Mreq->ifitsforu($pipename);
						if(isset($ifitsforu->result_array()[0]['ToWho'])){
							$answer = $ifitsforu->result_array()[0]['ToWho'];
							if ($answer==$_SESSION[$cookieValue]){
								// load string helper
								$this->load->helper('string');
								// load date helper
								$this->load->helper('date');
								// WTD (what to do)
								$wtd = "C";
								// uploded by
								$uploadedby = $towho = $_SESSION[$cookieValue];
								// get creator
								$ccreator = $this->Mreq->getunpipe($pipename, $towho);
								$creator = $ccreator->result_array()[0]['Creator'];
								// create unique id
								$uniqueid = random_string('md5',16);
								// set track
								$track = $ccreator->result_array()[0]['Track'];
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
										$config['max_size']             = 60000;
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
													$this->Mreq->upload($formname, $date, $time, $pipename, $uploadedby, $uniqueid, $creator, $wtd, $track);
													// reload signed page
													redirect(base_url().'/Req/signed');
										}
									}else{
										echo("Not meant for you");
										// reload signed page
										// redirect(base_url().'/Req/signed');
									}	
								}else{
									echo("Custom Error Empty");
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
		$sentto = $receivedby = $towho = $emailtosend;
		// unique id
		$uniqueid = $_SESSION['uniqueid'];
		// status init is pending
		$status = 'Pending';
		// get the rest
		$therest = $this->Mreq->getformdetails($uniqueid, $uploadedby);
		$pipename = $therest->result_array()[0]['PipeName'];
		$formname = $therest->result_array()[0]['FormName'];
		$wtd = $therest->result_array()[0]['Wtd'];
		$track = $therest->result_array()[0]['Track'];
		$creator = $therest->result_array()[0]['Creator'];
		if ($pipename != "" && $formname!= "" && $creator != ""){
			// send to sent DB
			$this->Mreq->intosend($formname, $date, $time, $pipename, $uniqueid, $sentto, $sentby, $creator, $status, $track);
			// send to received DB
			$this->Mreq->intoreceived($formname, $date, $time, $pipename, $uniqueid, $receivedby, $sentby, $creator, $status, $wtd, $track);
			// update pipe name table with details
			$this->Mreq->intounpipe($pipename, $creator, $fromwho, $towho, $uniqueid, $status, $track);
			// delete from specific pipe table 
			// $this->Mreq->delunpipe($pipename, $towho, $creator, $track);
			// delete sent form from the upload table
			$this->Mreq->deletefupload($uniqueid, $uploadedby);
			// turn off unique id of form sent
			// $_SESSION['uniqueid'] = 'off';
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
				// get the details of all inside that pipe
				$checkpipe = $this->Mreq->allspipe($pipename);
				// to know if the pipe is empty or not
				$checkpipe = $checkpipe->result_array();
				$obj = json_encode($checkpipe); 
				if($obj != "[]"){
					// delete sent form from the upload table
					$this->Mreq->deletefupload($uniqueid, $uploadedby);
				}elseif($obj == "[]"){
					// update pipe in use on DB
					$this->Mreq->upipenotinuse($pipename);
					// delete sent form from the upload table
					$this->Mreq->deletefupload($uniqueid, $uploadedby);
				}
				echo("success");
				// reload signed page
	    	// redirect(base_url().'/Req/signed');
				// turn off unique id of form sent
				$_SESSION['uniqueid'] = 'off';
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

// update status to approved controller
	function approvestat(){
		// load modal
		$this->load->model('Mreq');
		// get cookie value
		$cookieValue = get_cookie('sankoreR');
		// sentto is the name of logged in user
		$sentto = $receivedby = $towho = $_SESSION[$cookieValue];
		// unique id is 
		$uniqueid = $_SESSION['uniqueid'];
		if ($uniqueid != " "){
			// get pipe name to use on pipe table model
			$pipename = $this->Mreq->receievedpipe($uniqueid, $receivedby);
			$pipename = $pipename->result_array()[0]['PipeName'];
			
			// get received details from DB where unique id is given
			$getreceiveduid = $this->Mreq->getreceiveduid($uniqueid);
			// form name
			$formname = $getreceiveduid->result_array()[0]['FormName'];
			// creator
			$creator = $getreceiveduid->result_array()[0]['Creator'];
			// // sent by 
			$sentby = $getreceiveduid->result_array()[0]['SentBy'];
			// track
			$track = $getreceiveduid->result_array()[0]['Track'];
			// load date helper
			$this->load->helper('date');
			// date
			$datestring1 = '%Y/%m/%d';
			// time
			$datestring2 = '%h:%i %a';
			$time = time();
			$date = mdate($datestring1, $time);
			$time = mdate($datestring2, $time);	
			// update approved table on DB
			if (isset($sentby) OR isset($creator) OR isset($formname)){
				// $stats = $this->Mreq->getapprovedstat($uniqueid, $receivedby);
				// get all data with this uniqueID
				$ureceived = $this->Mreq->ureceived($uniqueid);
				// check status of what is about to be declined
				$cstatus = $ureceived->result_array()[0]['Status'];
				// check wtd status if its N or E or C
				$wtd = $ureceived->result_array()[0]['Wtd'];
				// echo($cstatus);
				if($cstatus == "Approved"){
					echo "Approved";
				}elseif($cstatus == "Declined") {
					echo("Declined");
				}elseif($cstatus == "DONE"){
					echo("Finished");
				}elseif($cstatus == "Pending"){
					if($wtd == "C"){
						// status is approved
						$status = 'DONE';
						//update and send details to model for sent table 
						$this->Mreq->nupdatestat($status, $track);
						//update and send details to model for received table
						$this->Mreq->nupdatestat_r($status, $track);
						// //update and send details to model for pipe table 
						// $this->Mreq->updatepipestat($pipename, $status, $uniqueid, $towho);
						// delete from specific pipe table 
						$this->Mreq->delunpipe($pipename, $towho, $creator, $track);
						// update pipe in use on DB to not in use
						$this->Mreq->upipenotinuse($pipename);
						// insert into appoved table
						$this->Mreq->approvedtable($formname, $date, $time, $pipename, $uniqueid, $receivedby, $sentby, $creator, $status, $track);
						echo "Done";
					}else{
						// status is approved
						$status = 'Approved';
						//update and send details to model for sent table 
						$this->Mreq->updatestat($status, $uniqueid, $sentto);
						//update and send details to model for received table
						$this->Mreq->updatestat_r($status, $uniqueid, $receivedby);
						//update and send details to model for pipe table 
						$this->Mreq->updatepipestat($pipename, $status, $uniqueid, $towho);
						// insert into appoved table
						$this->Mreq->approvedtable($formname, $date, $time, $pipename, $uniqueid, $receivedby, $sentby, $creator, $status, $track);	
						echo "Done";
					}
				}
			}else{
				echo "failed";
			}
		}else{
			echo "failed";
		}
	}

// download button 
	function dLoad(){
		// formname equals to download path
		$formname = $this->input->get('formname');
		// load modal
		$this->load->model('Mreq');
		// load download helper
		$this->load->helper('download');
		// read contents of the file into a variable
		$data = file_get_contents(base_url().'pdf/jupload/'.$formname);
		// downloader
		force_download($formname, $data);
	}

// declined function 
	function declineform(){
		//get declined message (reason)
		$reason = $this->input->post('reason');
		// set unique ID 
		$uniqueid = $_SESSION['uniqueid'];
		if ($uniqueid != " "){
			// load modal
			$this->load->model('Mreq');
			// get all data with this uniqueID
			$ureceived = $this->Mreq->ureceived($uniqueid);
			// set the values to be sent
			$formname = $ureceived->result_array()[0]['FormName'];
			$pipename = $ureceived->result_array()[0]['PipeName'];
			$declinedto = $ureceived->result_array()[0]['SentBy'];
			$declinedby = $ureceived->result_array()[0]['ReceivedBy'];
			$creator = $ureceived->result_array()[0]['Creator'];
			$track = $ureceived->result_array()[0]['Track'];
			// get cookie value
			$cookieValue = get_cookie('sankoreR');
			// sentto is the name of logged in user
			$sentto = $receivedby = $towho = $_SESSION[$cookieValue];
			// load date helper
			$this->load->helper('date');
			// date
			$datestring1 = '%Y/%m/%d';
			// time
			$datestring2 = '%h:%i %a';
			$time = time();
			$date = mdate($datestring1, $time);
			$time = mdate($datestring2, $time);	
			if (isset($sentby) OR isset($creator) OR isset($formname)){
				// check status of what is about to be declined
				$cstatus = $ureceived->result_array()[0]['Status'];
				if ($cstatus == "Pending"){
					// set status to declined
					$status = "Declined";
					//update and send details to model for sent table 
					$this->Mreq->nupdatestat($status, $track);
					//update and send details to model for received table
					$this->Mreq->nupdatestat_r($status, $track);
					// delete from specific pipe table 
					$this->Mreq->delunpipe($pipename, $track);
					// update pipe in use on DB to not in use
					$this->Mreq->upipenotinuse($pipename);
					// send details to the database 
					$this->Mreq->ideclined($formname, $date, $time, $pipename, $declinedby, $declinedto, $uniqueid, $reason, $creator, $status, $track);
					echo("Done");
				}elseif($cstatus == "Approved"){
					echo("Approved");
					// return "Approved";
				}elseif($cstatus == "Declined"){
					echo("Declined");
				}elseif($cstatus == "DONE"){
					echo("Finished");
				}
			}
		}
	}

// check if the pipe you want to use to send belongs to you
	function cifitsforu(){
		// load modal
		$pipename = $this->input->post('pipe');
		$this->load->model('Mreq');
		$ifitsforu = $this->Mreq->ifitsforu($pipename);
		if(isset($ifitsforu->result_array()[0]['ToWho'])){
			$answer = $ifitsforu->result_array()[0]['ToWho'];
			// get cookie value
			$cookieValue = get_cookie('sankoreR');
			if ($answer==$_SESSION[$cookieValue]){
				echo ("Valid");
			}else{
				echo("NotValid");
			}
		}else{
			echo("Empty");
		};
	}


// // what to do function( get value of what to set approve in document of recieved portal)
	// function wtd(){
	// 		// load modal
	// 		$this->load->model('Mreq');
	// 		$pipename = "Pipe2"; 
	// 		$checkpipe = $this->Mreq->allspipe($pipename);
	// 		$ffg = $checkpipe->result_array();
	// 		// get value of what to do from receive table
	// 		// $this->Mreq->wtd($uniqueid, $uploadedby);
	// 		$obj = json_encode($ffg); 
	// 		if($obj == "[]"){
	// 			echo "is not empty";
	// 		} 
	// 		// echo $obj;
	// }

}
?>
