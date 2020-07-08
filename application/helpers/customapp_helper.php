<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function _printr($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function dd() {
    array_map(function($x) {
        var_dump($x);
    }, func_get_args());
    die;
}

function generate_otp() {
    $otp = rand(1111, 9999);
    return $otp;
}

/* if (!function_exists('is_logged_in')) {

    function is_logged_in() {
        $CI = & get_instance();
        if (!empty($CI->session->userdata('users'))) {
            $requestFrom = 'users';
            $redirect = base_url('login');
            $islogged = $CI->session->userdata('users');
        }elseif(!empty($CI->session->userdata('agents'))) { 
			$requestFrom = 'agents';
			$redirect = base_url('login');
			$islogged = $CI->session->userdata('agents');
		}else {
            $requestFrom = 'admins';
            //$redirect = base_url('admin/login');
            $redirect = FRONTEND_URL;
            $islogged = $CI->session->userdata('admins');
        }
        if (!isset($islogged) || (!$islogged['is_logged_in']) || empty($islogged['user_id'])) {
            $CI->session->userdata($requestFrom, array('is_logged_in' => false, 'user_id' => '')
            );
            $CI->session->sess_destroy($requestFrom);
            redirect($redirect);
        }else{
			$user_id = $islogged['user_id'];
			$CI = & get_instance();
			$CI->load->model('user_model');
			$userdata 	= $CI->user_model->getDataBykey('nw_user_tbl', 'id', $user_id, '*');
			$status 	= !empty($userdata)?$userdata->status:'';
			return $status;
		}
    }
} */

if (!function_exists('randomstring')) {

    function randomstring($len = 10) {
        $string = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for ($i = 0; $i < $len; $i++) {
            $string .= substr($chars, rand(0, strlen($chars)), 1);
        }
        return $string;
    }
}

if (!function_exists('_manage_template')) {

    function _manage_template($header, $footer, $pageName, $data = array(), $leftAdminMenu = "") {
        $CI = & get_instance();
        $CI->load->model('user_model');
        $CI->load->view($header, $data);
        if ($pageName != "login" && !empty($leftAdminMenu)) {
            $head['userData'] = $CI->user_model->getDataBykey('nw_user_tbl', 'id', $CI->session->userdata('user_id'), '*');
            $CI->load->view($leftAdminMenu, $head);
        }
        $CI->load->view($pageName, $data);
        $CI->load->view($footer);
    }

}

// ========== Data table =========
function getDatatableData($query) {
    $new_query = preg_replace("/(?<=SELECT )[a-z,._()\r\t\n\s]+(?= FROM)/i", "count(*) as total", $query);
    $new_query = preg_replace("/(limit)[\d,\s]*/i", "", $new_query);
    $CI = & get_instance();
    $total = $CI->db->query($new_query)->num_rows();
    return [
        'draw' => 0,
        'recordsTotal' => $total,
        'recordsFiltered' => $total,
        'data' => $CI->db->query($query)->result_array()
    ];
}

function __dashboardtablehtml($data, $request = null) {
    $html = '<tbody>';
    if ($data['count'] > 0) {
        if ($request == null) {
            foreach ($data['data'] as $val) {
                $statusRes = __getStatus($val->usersStatus);
                $html .= '<tr><td>' . ucfirst(__getFirstNameFromFullName($val->name)) . '</td><td>' . $val->email . '</td>'
                        . '<td><span class="float-right' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span></td></tr>';
            }
        } else {
            foreach ($data['data'] as $val) {
                $statusRes = __getStatus($val->status);
                $html .= '<tr><td>' . ucfirst($val->customId) . '</td><td>' . substr($val->description, 0, 20).'...</td>'
                        . '<td><span class="float-right' . $statusRes["spanClass"] . '">' . ucfirst($statusRes['status']) . '</span></td></tr>';
            }
        }
    } else {
        $html .= '<tr><td>No Record Available.</td></tr>';
    }
    $html .= '</tbody>';
    $fivehtml['html'] = $html;
    $fivehtml['count'] = $data['count'];
    return $fivehtml;
}

function __getStatus($status, $class = null) {
    if ($class == null) {
        $class = ''; //float-right
    }
    if ($status == 0) {
        $status = 'inactive';
        $spanClass = $class . ' badge bg-danger';
    } elseif ($status == 1) {
        $status = 'active';
        $spanClass = $class . ' badge bg-success';
    } elseif ($status == 10) {
        $status = 'unassigned';
        $spanClass = $class . ' badge bg-success';
    } elseif ($status == 20) {
        $status = 'Assigned';
        $spanClass = $class . ' badge bg-success';
    } elseif ($status == 21) {
        $status = 'Response Awaited';
        $spanClass = $class . ' badge bg-warning';
    } elseif ($status == 22) {
        $status = 'Inprogress';
        $spanClass = $class . ' badge bg-success';
    } elseif ($status == 2) {
        $status = 'pending';
        $spanClass = $class . ' badge bg-info';
    } elseif ($status == 3) {
        $status = 'deleted';
        $spanClass = $class . ' badge bg-danger';
    }elseif ($status == 90) {
        $status = 'Completed';
        $spanClass = $class . ' badge bg-danger';
    }elseif ($status == 91) {
        $status = 'Cancelled';
        $spanClass = $class . ' badge bg-danger';
    } elseif ($status == 92) {
        $status = 'Submitted to admin for closer';
        $spanClass = $class . ' badge bg-danger';
    } elseif ($status == 93) {
        $status = 'Request for reassign';
        $spanClass = $class . ' badge bg-info';
    }elseif ($status == 5) {
        $status = 'Leads';
        $spanClass = $class . ' badge bg-warning';
    } else {
        $status = 'not defined';
        $spanClass = $class . ' badge bg-danger';
    }
    $data['status'] = $status;
    $data['spanClass'] = $spanClass;
    return $data;
}

function __getFirstNameFromFullName($fullName, $checkFirstNameLength = TRUE) {
    if (!empty($fullName)) {
        $nameParts = explode(' ', $fullName);
        $firstName = $nameParts[0];
        if (in_array(strtolower($firstName), array('mr', 'ms', 'mrs', 'miss', 'dr'))) {
            if ($nameParts[2] != '') {
                $firstName = $nameParts[1];
            } else {
                $firstName = $fullName;
            }
        }
        if ($checkFirstNameLength && strlen($firstName) < 3) {
            $firstName = $fullName;
        }
    } else {
        $firstName = DEFAULT_VALUE;
    }
    return $firstName;
}

function _settingBykey($key) {
    $CI = & get_instance();
    $CI->load->model('setting_model', 'settings');
    $responce = $CI->settings->getSettingDataByKey($key);
    if (empty($responce)) {
        $responce = DEFAULT_VALUE;
    } else {
        $responce = $responce->key_value;
    }
    return $responce;
} 

function uploadImage($original_name, $tmp_name, $folder_name, $thumbSize = '') {
    if (!empty($original_name)) {
        $file_extension = _getExtension($original_name);
        $original_name 	= cleanString($original_name) . '.' . $file_extension;
        //$tmp_path = @$_FILES['image']['tmp_name'];
        $targetPath = 'uploads/' . $folder_name . '/';
		$rndstr 	= randomstring();
        $imgName 	= mktime(date("h"), date("i"), date("s"), date("m"), date("d"), date("y")) . "_" . @$rndstr.'.'.$file_extension;
        $targetFile = str_replace('//', '/', $targetPath) . $imgName;
        if (!file_exists($targetPath)) {
            mkdir(str_replace('//', '/', $targetPath), 0777, true);
        }
        $image_name = move_uploaded_file($tmp_name, $targetFile);

        $arr = explode('/', $targetPath);
        $arr = array_reverse($arr);

        $info = pathinfo($targetPath . $imgName);
        $getimg = getimagesize($targetPath . $imgName);
        //list($width, $height, $type, $attr) = getimagesize($targetPath.$imgName);
        $width = $getimg[0];
        $height = $getimg[1];
        $type = $getimg[2];
        $attr = $getimg[3];

        $img = null;
        if ($info['extension'] == 'jpg' || $info['extension'] == 'jpeg' || $info['extension'] == 'JPG' || $info['extension'] == 'JPEG'){
            $img = imagecreatefromjpeg("{$targetFile}");
        }
        if ($info['extension'] == 'gif' || $info['extension'] == 'GIF'){
            $img = imagecreatefromgif("{$targetFile}");
        }
        if ($info['extension'] == 'png' || $info['extension'] == 'PNG'){
            $img = imagecreatefrompng("{$targetFile}");
        }

        if($img!=null){
            if ($thumbSize){
                $thumbWidth = $thumbSize;
            }else{
                $thumbWidth = 60;
            }
            ############## code for thumb ################
            if ($width < $thumbWidth){
                $thumbWidth = $width;
            }

            $width = imagesx($img);
            $height = imagesy($img);
            $new_height = floor($height * ( $thumbWidth / $width ));
            $new_width = $thumbWidth;

            $tmp_img = imagecreatetruecolor($new_width, $new_height);
            imagealphablending($tmp_img, false);
            imagesavealpha($tmp_img, true);
            $transparent = imagecolorallocatealpha($tmp_img, 255, 255, 255, 127);
            imagecopyresized($tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            $targetFile1 = str_replace('//', '/', $targetPath) . 'thumb_' . $imgName;

            if ($info['extension'] == 'jpg' || $info['extension'] == 'jpeg' || $info['extension'] == 'JPG' || $info['extension'] == 'JPEG'){
                imagejpeg($tmp_img, "{$targetFile1}");
            }
            if ($info['extension'] == 'gif' || $info['extension'] == 'GIF'){
                imagegif($tmp_img, "{$targetFile1}");
            }
            if ($info['extension'] == 'png' || $info['extension'] == 'PNG'){
                imagepng($tmp_img, "{$targetFile1}");
            }
        }
        return $imgName;
    }
    return false;
}

//get extension of image
function _getExtension($filename) {
    $file_extension = "";
    if ($filename) {
        $info = pathinfo($filename);
        $file_extension = strtolower($info['extension']);
    }
    return $file_extension;
}

function _getGEOLocationByAddress($address) {
    $prepAddr = str_replace(' ', '+', $address);
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
    $output = json_decode($geocode);
    if (!empty($output->results)) {
        $lat = $output->results[0]->geometry->location->lat;
        $long = $output->results[0]->geometry->location->lng;
        $geoData['lat'] = $lat;
        $geoData['long'] = $long;
    } else {
        $geoData['lat'] = '';
        $geoData['long'] = '';
    }
    return $geoData;
}

function dateDifference($date_1, $date_2, $differenceFormat = '%a') {
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    $interval = date_diff($datetime1, $datetime2);
    return $interval->format($differenceFormat);
}

function unlinkImage($path, $imagename) {
    @unlink(FCPATH . $path . $imagename);
    @unlink(FCPATH . $path . 'thumb_' . $imagename);
    return true;
}

function cleanString($string) {
    // allow only letters
    $res = preg_replace("/[^a-zA-Z]/", "", $string);
    // trim what's left to 8 chars
    $res = substr($res, 0, 8);
    // make lowercase
    $res = strtolower($res);
    // return
    return $res;
}

function removeCommaFromLast($string, $seprater) {
    return rtrim($string, '"' . $seprater . '"');
}

function fileExistsInLoacation($imgName = null, $folder_name = null,$for=null) {
    if (!empty($imgName)) {
        $targetPath = 'uploads/' . $folder_name . '/';
        $targetFile = $targetPath . $imgName;
        if (file_exists($targetFile)) {
            return array('status' => true, 'target' => base_url() . $targetFile);
        } else {
            return array('status' => false, 'target' => base_url('uploads/profile/no_image_available.jpeg'));
        }
    } else {
        if(empty($for)){
            return array('status' => true, 'target' => base_url('uploads/profile/no_image_available.jpeg'));
        }else{
            return array('status' => true, 'target' => base_url('uploads/profile/no_image_available.jpeg'));
        }
    }
}

function url() {
    return sprintf(
            "%s://%s%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http', $_SERVER['SERVER_NAME'], $_SERVER['REQUEST_URI']
    );
}

function does_url_exists($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}

function sendEmail($mailTo = null, $var = null, $val = null, $mailShortCode = null) {
    $CI = & get_instance();
    //=======================
    $CI->load->library('phpmailer');
    $CI->load->library('smtp');
    $CI->phpmailer->SMTPDebug = 2;                                 // Enable verbose debug output
    $CI->phpmailer->isSMTP();                                      // Set mailer to use SMTP
    $CI->phpmailer->Host = 'smtp.gmail.com';  //smtp.zoho.com// Specify main and backup SMTP servers
//    $CI->phpmailer->SMTPAuth = true;                               // Enable SMTP authentication
    $CI->phpmailer->Username = '';                 // SMTP username
    $CI->phpmailer->Password = '';                           // SMTP password
    $CI->phpmailer->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $CI->phpmailer->Port = 465;                                    // TCP port to connect to
    //Recipients
    $CI->phpmailer->setFrom('acc.00amit@gmail.com', 'Mailer');
    $CI->phpmailer->addAddress('acc.00amit@gmail.com', 'Preety Singh');     // Add a recipient
    //Content
    $CI->phpmailer->isHTML(true);                                  // Set email format to HTML
    $CI->phpmailer->Subject = 'Here is the subject';
    $CI->phpmailer->Body = 'This is the HTML message body <b>in bold! Hi,</b>';
    $CI->phpmailer->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$CI->phpmailer->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $CI->phpmailer->ErrorInfo;
        //  exit();
    } else {
        echo 'Message has been sent';
        // exit();
    }
    $CI->phpmailer->smtpClose();
}

if (!function_exists('randomPassword')) {
    /* function randomPassword() {
        $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-@._*$%^&`~#()/+=';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    } */
	function randomPassword() {
		//enforce min length 8
		$len = 8;

		//define character libraries - remove ambiguous characters like iIl|1 0oO
		$sets = array();
		$sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
		$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		$sets[] = '23456789';
		$sets[]  = '~!@#$%^&*(){}[],./?';

		$password = '';
		
		//append a character from each set - gets first 4 characters
		foreach ($sets as $set) {
			$password .= $set[array_rand(str_split($set))];
		}

		//use all characters to fill up to $len
		while(strlen($password) < $len) {
			//get a random set
			$randomSet = $sets[array_rand($sets)];
			
			//add a random char from the random set
			$password .= $randomSet[array_rand(str_split($randomSet))]; 
		}
		
		//shuffle the password string before returning!
		return str_shuffle($password);
	}
}
	if(!function_exists('getMailTemplate')){
		function getMailTemplate($body){
			$html = '';
			$html .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
			  $html .= '<tbody>';
				$html .= '<tr>';
				  $html .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#f8f8f8" style="font-family:helvetica, sans-serif;" class="MainContainer">';
					  $html .= '<tbody>';
						$html .= '<tr>';
						  $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
							  $html .= '<tbody>';
								$html .= '<tr>';
								  $html .= '<td><table width="100%" border="0" cellspacing="0" cellpadding="0">';
									  $html .= '<tbody>
										<tr>
										  <td class="movableContentContainer"><div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
											  <table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tbody style="background-color:#222">
												  <tr>
													<td height="15"></td>
												  </tr>
												  <tr>
													<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
														  <tr>
															<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tbody>
																  <tr>
																	<td valign="top" width="" style="padding-left:15px;text-align: center;"><a href="'.FRONTEND_URL.'"><img src="'.FRONTEND_URL.'uploads/settings/logo.png" width="auto" height="45"></a></td>
																  </tr>
																</tbody>
															  </table></td>
														  </tr>
														</tbody>
													  </table></td>
												  </tr>
												  <tr>
													<td height="15"></td>
												  </tr>
												</tbody>
											  </table>';
											$html .= '</div>';
											$html .= '<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
											  <table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:0 15px; border:1px solid #b6b6b6">
												<tbody>
												  <tr>
													<td height="18"></td>
												  </tr>
												  <tr>
													<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tbody>
														  <tr>
															<td class="specbundle"><div class="contentEditableContainer contentTextEditable">
																<div class="contentEditable" style="text-align: left;">';
																  $html .= ''.$body.'<br>
																</div>
															  </div></td>
														  <tr>
															<td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Regards,</td>
														  </tr>
														  <tr>
															<td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Administrator</td>
														  </tr>
														  <tr>
															<td class="specbundle" style="font-family:helvetica, sans-serif;color:#000000;">Filenotice</td>
														  </tr>
														  <tr>
															<td class="specbundle">&nbsp;</td>
														  </tr>
														</tbody>
													  </table></td>
												  </tr>
												</tbody>
											  </table>
											</div>
											<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
											  <table style="background-color: #272727;" width="100%" cellspacing="0" cellpadding="0" border="0">
												<tbody>
												  <tr>
													<td height="8"></td>
												  </tr>
												  <tr>
													<td height="8"><div class="contentEditableContainer contentTextEditable">
														<div class="contentEditable" style="text-align: center;color:#AAAAAA;">
														  <p style="margin:2px 0; font-size:10px;"> &copy; '.date("Y").' Filenotice </p>
														</div>
													  </div></td>
												  </tr>
												  <tr>
													<td height="8"></td>
												  </tr>
												</tbody>
											  </table>
											</div></td>
										</tr>
									  </tbody>
									</table></td>
								</tr>
							  </tbody>
							</table></td>
						</tr>
					  </tbody>
					</table></td>
				</tr>
			  </tbody>
			</table>';
			return  $html;
		}
	}