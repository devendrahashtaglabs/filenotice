<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller']  	= "welcome";
//$route['default_controller']	= 'frontend/frontController/index';
$route['404_override']      	= 'errormanager/page404';
$route['registration']          = 'frontend/frontController/registration';
$route['verify_email']          = 'frontend/frontController/verify_email';
$route['login']            		= 'frontend/frontController/login';
$route['forgetpassword']        = 'frontend/frontController/forgetpassword';
$route['resetpassword']        	= 'frontend/frontController/resetpassword';
$route['about']            		= 'frontend/frontController/about';
$route['contact']            	= 'frontend/frontController/contact';
$route['create_ticket']  		= 'frontend/ticketController/create_ticket';
$route['createnewticket']  		= 'frontend/ticketController/createnewticket';
$route['payment']  				= 'frontend/ticketController/payment';
//$route['payment_response']  	= 'frontend/ticketController/payment_response';

$route['customlogin']           = 'frontend/ticketController/customlogin';
$route['getsubcatform']         = 'frontend/ticketController/getsubcatform';
// Customer Routes
//$route['registration']          = 'users/usersController/registration';
//$route['login']            		= 'users/usersController/login';
$route['logout']                = 'users/usersController/logout';
$route['dashboard']             = 'users/usersController/dashboard';
//$route['wplogin']             = 'users/wpController/wp_login';
//$route['wplogin/(:num)']		= 'users/usersController/wp_login/$1';
$route['ticket/list']           = 'users/customerController/tickets';
$route['ticket/create']         = 'users/ticketController/create_ticket';
$route['ticket/edit/(:any)']    = 'users/customerController/edit_ticket/$id';
$route['ticket/view/(:any)']    = 'users/customerController/view_ticket/$id';
$route['ticket/update']         = 'users/customerController/updateTicketRecords';
$route['ticket/assign']         = 'users/customerController/assign_list';
$route['ticket/new_assign_list']= 'users/customerController/new_assign_list';
$route['ticket/completed']      = 'users/customerController/completed_list';
$route['ticket/feedback']       = 'users/customerController/feedback';
$route['ticket/submit_feedback']       = 'users/customerController/submit_feedback';
$route['ticket/conversation/(:any)'] = 'users/customerController/conversation/$id';
$route['ticket/getChatDataByAjax/(:any)'] = 'users/customerController/getChatDataByAjax/$1';
$route['ticket/choose_category']= 'users/ticketController/choose_category';
$route['ticket/payment']		= 'users/ticketController/payment';
$route['ticket/createnewticket']= 'users/ticketController/createnewticket';
$route['ticket/getsubcatform']	= 'users/ticketController/getsubcatform';
$route['ticket/servicelist']	= 'users/ticketController/servicelist';

$route['ticket/changeticketstatwithremark/(:any)'] = 'users/customerController/changeticketstatwithremark/$1';
$route['ticket/raiserequestwithremark/(:any)'] = 'users/customerController/raiserequestwithremark/$1';

$route['profile']               		= 'users/customerController/profile';
$route['profile2']              		= 'users/customerController/updateProfile2';
$route['profile3']              		= 'users/customerController/updateProfile3';
$route['profile4']              		= 'users/customerController/updateProfile4';
$route['profile5']              		= 'users/customerController/updateProfile5';
$route['other-Info']            		= 'users/customerController/other_Info';
$route['change-password']       		= 'users/customerController/change_password';
		
$route['agent']              			= 'users/customerController/agent_list';
$route['agent/addagent']        		= 'users/customerController/addagent';
$route['agent/addagent_info/(:any)']    = 'users/customerController/addagent_info/$id';
$route['agent/agentview/(:any)']   		= 'users/customerController/agentview/$id';
$route['agent/editagent/(:any)']   		= 'users/customerController/editagent/$id';
$route['agent/editagent_info/(:any)']   = 'users/customerController/editagent_info/$id';
$route['agent/updateAgentRecords']  	= 'users/customerController/updateAgentRecords';
$route['ticket/assignagent/(:any)'] 	= 'users/customerController/assignagent/$id';
$route['ticket/needhelp']   			= 'users/customerController/needhelp';

// Agents Module Routes
$route['agent/wplogin/(:num)']				= 'agents/usersAgentController/wp_login/$1';
$route['agent/dashboard']       			= 'agents/usersAgentController/dashboard';
$route['agent/ticket/assign']   			= 'agents/agentController/assign_list';
$route['agent/ticket/completed']			= 'agents/agentController/completed_list';
$route['agent/ticket/feedback']				= 'agents/agentController/feedback';
$route['agent/profile']						= 'agents/agentController/profile';
$route['agent/change-password']				= 'agents/agentController/change_password';
$route['agent/logout']						= 'agents/usersAgentController/logout';
$route['agent/ticket/view/(:any)']  		= 'agents/agentController/view_ticket/$id';
$route['agent/profile2']            		= 'agents/agentController/updateProfile2';
$route['agent/ticket/conversation/(:any)'] 	= 'agents/agentController/conversation/$id';
$route['agent/ticket/changeticketstatwithremark/(:any)'] = 'agents/agentController/changeticketstatwithremark/$1';

// Admin Routes
$route['admin/login']           = 'admin/admin/login';
$route['admin/logout']          = 'admin/admin/logout';
$route['admin/dashboard']       = 'admin/admin/dashboard';
$route['admin/profile']         = 'admin/admin/profile';
$route['admin/change-password'] = 'admin/admin/change_password';

/* End of file routes.php */
/* Location: ./application/config/routes.php */