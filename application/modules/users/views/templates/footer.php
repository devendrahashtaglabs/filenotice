<?php
	$usersessiondata = $this->session->userdata('users');
	if ((!empty($usersessiondata['user_id']))) {
		echo '<footer class="main-footer">
				<div class="float-right d-none d-sm-block">
				  <b>Hasthtaglabs</b>
				</div>
				<strong>Copyright &copy; '.date("Y").' <a href="http://hashtaglabs.in/" target="_blank">Hasthtag Labs</a>.</strong> All rights
			reserved.
			</footer>
		</div>';
	}
?>
<style>
	.verifiedconsultant .modal-danger .modal-header, .modal-danger .modal-footer {
		background-color: #dd4b39 !important;
	}
	.verifiedconsultant .modal-danger .modal-body {
		background-color: #dd4b39 !important;
	}
	.verifiedconsultant .modal-body p{
		color:#fff;
	}
	.verifiedconsultant .modal-header{
		border:none !important;
	}
	.verifiedconsultant .modal-header span{
		color:#fff;
	}
</style>
<div class="row verifiedconsultant">
	<div class="modal modal-danger fade" id="modal-danger">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Please complete your profile, for verification and avail the services from Filenotice.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	if($this->session->userdata('users')['user_type'] == 'consultant'){ 
		$user_id 		= $this->session->userdata('users')['user_id'];
		$consultantdata = $this->user_model->getDataBykey('nw_consultant_tbl','user_id',$user_id);
		if($consultantdata->verified_consultant == '0'){
?>
<script type="text/javascript">
    $(window).on('load',function(){
        $('#modal-danger').modal('show');
    });
</script>
<?php } } ?>
<script src="<?php echo base_url() . 'cosmatics/plugins/bootstrap/js/bootstrap.bundle.min.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/plugins/fastclick/fastclick.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/plugins/datatables/dataTables.bootstrap4.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/js/adminlte.min.js'; ?>" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/js/base64_encode.js' ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/js/app.js'; ?>" type="text/javascript"></script> 
<script src="<?php echo base_url() . 'cosmatics/validation/jquery.validate.min.js'; ?>" type="text/javascript"></script> 
<script src="<?php echo base_url() . 'cosmatics/validation/additional-methods.js'; ?>" type="text/javascript"></script> 
<script src="<?php echo base_url() . 'cosmatics/validation/email-validation.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/validation/mask.min.js'; ?>" type="text/javascript"></script>
<?php 
	$currenturl 		= current_url();
	$currenturlarray 	= explode('/',$currenturl);
	if(in_array("getsubcatform", $currenturlarray)){
?>
<script type="text/javascript" src="<?php echo base_url().'cosmatics/plugins/alpacaform/moment.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'cosmatics/plugins/alpacaform/handlebars.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'cosmatics/plugins/alpacaform/query.maskedinput.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo base_url().'cosmatics/plugins/alpacaform/alpaca.min.js'; ?>"></script>
<?php } ?>
<script src="<?php echo base_url() . 'cosmatics/validation/custom.js'; ?>" type="text/javascript"></script> 

<!--<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
<script>
	var $base_url = "<?php echo base_url(); ?>";
	function hideSuccessMsg() {
		$('.alert-dismissible').hide();
	}
	$(function () {
		setTimeout(function () {
			hideSuccessMsg();
		}, 4000);
		$("#example1").DataTable();
		chatListScroll();
	});
	//$(document).ready(function () {
		$('#ticketfile_table_id').DataTable({
			stateSave: true
		});
		$('#table_id').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [
				//'excel', 'csv'
				'excel'
			]
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$('#certificate_table').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [
				'excel'
			]
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		
		<?php 
			if($this->uri->segment(2) == 'new_assign_list'){
		?>
			$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var assignmin 	= $('#assignmin').datepicker("getDate");
				var assignmax 	= $('#assignmax').datepicker("getDate");
				if(assignmax != null){
					assignmax.setDate(assignmax.getDate() + 1);
					assignmax.setSeconds(assignmax.getSeconds() - 1);
				}
				var newdate 	= data[7].split("-").reverse().join("-");
				var assignstartDate = new Date(newdate);
				if (assignmin == null && assignmax == null) { return true; }
				if (assignmin == null && assignstartDate <= assignmax) { return true;}
				if(assignmax == null && assignstartDate >= assignmin) {return true;}
				if (assignstartDate <= assignmax && assignstartDate >= assignmin) { return true; }
				return false; 
			}
			);
			$("#assignmin").datepicker({ 
				onSelect: function () { assigntable.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#assignmax").datepicker({
				onSelect: function () { assigntable.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			var assigntable = $('#ticket_table_id').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [{
				extend: 'excel',
				charset: 'UTF-8',
				exportOptions: {
					columns: [0,1,2,3,4,5,6,7,8]
				},
				filename: function fred() { return "Ticket" + Date.now(); },
			}/* ,{
				extend: 'pdf',
				charset: 'UTF-8',
				exportOptions: {
					columns: [0,1,2,3,4,5,6,7,8]
				}
			} ,{
				extend: 'csv',
				charset: 'UTF-8',
				bom: true,
				exportOptions: {
					columns: [0,1,2,3,4,5,6,7,8]
				},
				filename: function fred() { return "Ticket" + Date.now(); },
			}*/
			],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			initComplete: function () {
				this.api().columns(2).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- Category -</option></select>')
						.appendTo( $('.FilterCustom1').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
				this.api().columns(3).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- Subcategory -</option></select>')
						.appendTo( $('.FilterCustom2').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
				this.api().columns(5).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- State -</option></select>')
						.appendTo( $('.FilterCustom3').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
				this.api().columns(6).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- City -</option></select>')
						.appendTo( $('.FilterCustom4').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
			}
		});
		$('#assignmin, #assignmax').change(function () {
			assigntable.draw();
		});
			
		<?php } ?>
		$('#ticket_status_table').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,3,4,5,7,8]
				},
				filename: function fred() { return "Ticketstatus" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,3,4,5,7,8]
				}
			},{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,5,7,8]
				},
				filename: function fred() { return "Ticketstatus" + Date.now(); },
			} */
			],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		<?php 
			if(isset($status)){
				if(empty($status)|| $status == '10'){
		?>
			$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var assignmin 	= $('#assignmin').datepicker("getDate");
				var assignmax 	= $('#assignmax').datepicker("getDate");
				if(assignmax != null){
					assignmax.setDate(assignmax.getDate() + 1);
					assignmax.setSeconds(assignmax.getSeconds() - 1);
				}
				var newdate 	= data[7].split("-").reverse().join("-");
				var assignstartDate = new Date(newdate);
				if (assignmin == null && assignmax == null) { return true; }
				if (assignmin == null && assignstartDate <= assignmax) { return true;}
				if(assignmax == null && assignstartDate >= assignmin) {return true;}
				if (assignstartDate <= assignmax && assignstartDate >= assignmin) { return true; }
				return false; 
			}
			);
			$("#assignmin").datepicker({ 
				onSelect: function () { ticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#assignmax").datepicker({
				onSelect: function () { ticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			var ticketlist_table = $('#ticketlist_table').DataTable({
				stateSave: true,
				dom: 'lBfrtip',
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10', '25', '50', 'All' ]
				],
				language: {
							search: "",
							searchPlaceholder: "Search",
							sLengthMenu: " _MENU_",
						},
				buttons: [{
					extend: 'excel',
					exportOptions: {
						columns: [0,1,2,3,4,5,7,8]
					},
					filename: function fred() { return "Ticketstatus" + Date.now(); },
				},/* {
					extend: 'pdf',
					exportOptions: {
						columns: [0,1,3,4,5,7,8]
					}
				},{
					extend: 'csv',
					exportOptions: {
						columns: [0,1,3,4,5,7,8]
					},
					filename: function fred() { return "Ticketstatus" + Date.now(); },
				} */
				],
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				initComplete: function () {
					this.api().columns(2).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Category -</option></select>')
							.appendTo( $('.FilterCustom1').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
					this.api().columns(3).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Subcategory -</option></select>')
							.appendTo( $('.FilterCustom2').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
					this.api().columns(5).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- State -</option></select>')
							.appendTo( $('.FilterCustom3').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
					this.api().columns(6).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- City -</option></select>')
							.appendTo( $('.FilterCustom4').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != '' && d != 'NA'){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
				}
			});
			$('#assignmin, #assignmax').change(function () {
				ticketlist_table.draw();
			});
			<?php }elseif($status == '20'){ ?>
			$.fn.dataTable.ext.search.push(
				function (settings, data, dataIndex) {
					var assignmin = $('#assignmin').datepicker("getDate");
					var assignmax = $('#assignmax').datepicker("getDate");
					<?php 
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						var newdate 	= data[12].split("-").reverse().join("-");
					<?php }else{ ?>
						var newdate 	= data[8].split("-").reverse().join("-");
					<?php } } ?>
					var assignstartDate = new Date(newdate);
					if(assignmax != null){
						assignmax.setDate(assignmax.getDate() + 1);
						assignmax.setSeconds(assignmax.getSeconds() - 1);
					}
					if (assignmin == null && assignmax == null) { return true; }
					if (assignmin == null && assignstartDate <= assignmax) { return true;}
					if(assignmax == null && assignstartDate >= assignmin) {return true;}
					if (assignstartDate <= assignmax && assignstartDate >= assignmin) { return true; }
					return false; 
				}
			);
			$("#assignmin").datepicker({ 
				onSelect: function () { assignticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#assignmax").datepicker({
				onSelect: function () { assignticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			var assignticketlist_table = $('#assignticketlist_table').DataTable({
				stateSave: true,
				dom: 'lBfrtip',
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10', '25', '50', 'All' ]
				],
				language: {
							search: "",
							searchPlaceholder: "Search",
							sLengthMenu: " _MENU_",
						},
				<?php 
					if(!empty($usersessiondata)){
					if($usersessiondata['user_type'] == 'consultant'){
				?>
				columnDefs: [
				   { type: 'de_datetime', targets: 17 }
				 ],
				order: [[ 17, "desc" ]],
				<?php }else{ ?>
				columnDefs: [
				   { type: 'de_datetime', targets: 12 }
				 ],
				order: [[ 13, "desc" ]],
				<?php }} ?>
				buttons: [{
					extend: 'excel',
					exportOptions: {
						<?php 
							if(!empty($usersessiondata)){
							if($usersessiondata['user_type'] == 'consultant'){
						?>
							columns: [0,1,2,3,4,5,7,8,9,10,11,12,14,15]
						<?php }else{ ?>
							columns: [0,1,3,4,5,6,7,8,10,11]
						<?php }}  ?>
					},
					filename: function fred() { return "Assigned" + Date.now(); },
				},/* {
					extend: 'pdf',
					exportOptions: {
						<?php
							if(!empty($usersessiondata)){
							if($usersessiondata['user_type'] == 'consultant'){
						?>
							columns: [0,1,2,3,4,5,7,8,9,10,11,12,14,15]
						<?php }else{ ?>
							columns: [0,1,3,4,5,6,7,8,10,11]
							<?php } } ?>
					},
					orientation: 'landscape',
					pageSize: 'LEGAL'
				}, {
					extend: 'csv',
					exportOptions: {
						<?php 
							if(!empty($usersessiondata)){
							if($usersessiondata['user_type'] == 'consultant'){
						?>
							columns: [0,1,2,3,4,5,7,8,9,10,11,12,14,15]
						<?php }else{ ?>
							columns: [0,1,3,4,5,6,7,8,10,11]
						<?php } } ?>
					},
					filename: function fred() { return "Assigned" + Date.now(); },
				}*/
				],
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
				initComplete: function () {
					<?php 
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						var catcolumn = '10';
					<?php }else{ ?>
						var catcolumn = '6';
					<?php } } ?>
						this.api().columns(catcolumn).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Category-</option></select>')
							.appendTo( $('.FilterCustom1').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );				
										
						column.data().unique().sort().each( function ( d, j ) {
							if(d != 'NA'){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					<?php 
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						var subcatcolumn = '11';
					<?php }else{ ?>
						var subcatcolumn = '7';
					<?php } } ?>
						this.api().columns(subcatcolumn).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Subcategory-</option></select>')
							.appendTo( $('.FilterCustom2').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );				
										
						column.data().unique().sort().each( function ( d, j ) {
							if(d != 'NA'){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					<?php 
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						var statuscolumn = '14';
					<?php }else{ ?>
						var statuscolumn = '10';
					<?php } } ?>
						this.api().columns(statuscolumn).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Status-</option></select>')
							.appendTo( $('.FilterCustom3').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );	
						column.data().unique().sort().each( function ( d, j ) {					
							if(d != 'NA'){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
				}
			});
		//});
		$('#assignmin, #assignmax').change(function () {
			assignticketlist_table.draw();
		});
		<?php }elseif($status == '90' ){ ?>
			$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var assignmin = $('#assignmin').datepicker("getDate");
				var assignmax = $('#assignmax').datepicker("getDate");
				var newdate 	= data[7].split("-").reverse().join("-");
				if(assignmax != null){
					assignmax.setDate(assignmax.getDate() + 1);
					assignmax.setSeconds(assignmax.getSeconds() - 1);
				}
				var assignstartDate = new Date(newdate);
				if (assignmin == null && assignmax == null) { return true; }
				if (assignmin == null && assignstartDate <= assignmax) { return true;}
				if(assignmax == null && assignstartDate >= assignmin) {return true;}
				if (assignstartDate <= assignmax && assignstartDate >= assignmin) { return true; }
				return false; 
			}
			);
			$("#assignmin").datepicker({ 
				onSelect: function () { completedticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#assignmax").datepicker({
				onSelect: function () { completedticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			var completedticketlist_table = $('#completedticketlist_table').DataTable({
				stateSave: true,
				dom: 'lBfrtip',
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10', '25', '50', 'All' ]
				],
				language: {
							search: "",
							searchPlaceholder: "Search",
							sLengthMenu: " _MENU_",
						},
				buttons: [{
					extend: 'excel',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
					},
					filename: function fred() { return "Completed" + Date.now(); },
				},/* {
					extend: 'pdf',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
					}
				}, {
					extend: 'csv',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
					},
					filename: function fred() { return "Completed" + Date.now(); },
				}*/ 
				],
				<?php 
					if(!empty($usersessiondata)){
					//if($usersessiondata['user_type'] != 'consultant'){
				?>
				initComplete: function () {
					this.api().columns(3).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Category-</option></select>')
							.appendTo( $('.FilterCustom1').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
					this.api().columns(4).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Subcategory-</option></select>')
							.appendTo( $('.FilterCustom2').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
				<?php } //} ?>
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			});
			$('#assignmin, #assignmax').change(function () {
				completedticketlist_table.draw();
			});
		<?php }else{ ?>
			$('#allticketlist_table').DataTable({
				stateSave: true,
				dom: 'lBfrtip',
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10', '25', '50', 'All' ]
				],
				language: {
							search: "",
							searchPlaceholder: "Search",
							sLengthMenu: " _MENU_",
						},
				buttons: [{
					extend: 'excel',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7,8]
					},
					filename: function fred() { return "Customerticketstatus" + Date.now(); },
				},/* {
					extend: 'pdf',
					exportOptions: {
						columns: [0,1,2,3,4]
					}
				}, {
					extend: 'csv',
					exportOptions: {
						columns: [0,1,2,3,4]
					},
					filename: function fred() { return "Customerticketstatus" + Date.now(); },
				}*/
				],
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			});			
		<?php } } ?>
		$('#customer_ticket_status_table').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,2,3,4]
				},
				filename: function fred() { return "Customerticketstatus" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,3,4]
				}
			}, {
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2,3,4]
				},
				filename: function fred() { return "Customerticketstatus" + Date.now(); },
			}*/
			],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$('#feedback_table_id').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,2,3,4,5,6,7,9]
				},
				filename: function fred() { return "Feedback" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,3,4,5,6,7,9]
				}
			}, {
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2,3,4,5,6,7,9]
				},
				filename: function fred() { return "Feedback" + Date.now(); },
			}*/
			],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$('#needhelp_table_id').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8,10]
				},
				filename: function fred() { return "Needhelp" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8,10]
				},
				title: 'Help_pdf'
			}, {
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8,10]
				},
				filename: function fred() { return "Needhelp" + Date.now(); },
			}*/
			],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$('#agent_table_id').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			initComplete: function () {
				this.api().columns(10).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- Status -</option></select>')
						.appendTo( $('.FilterCustom1').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						select.append( '<option value="'+d+'">'+d+'</option>' )
					} );
				} );
			},
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,11]
				},
				filename: function fred() { return "Agent" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,11]
				}
			}, {
				extend: 'csv',
				exportOptions: {
					columns: [0,2,3,4,5,6,7,8,9,11]
				},
				filename: function fred() { return "Agent" + Date.now(); },
			}*/],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		<?php 
			if($this->uri->segment(2) == 'completed'){
		?>
			$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var assignmin = $('#assignmin').datepicker("getDate");
				var assignmax = $('#assignmax').datepicker("getDate");
				var newdate 	= data[7].split("-").reverse().join("-");
				if(assignmax != null){
					assignmax.setDate(assignmax.getDate() + 1);
					assignmax.setSeconds(assignmax.getSeconds() - 1);
				}
				var assignstartDate = new Date(newdate);
				if (assignmin == null && assignmax == null) { return true; }
				if (assignmin == null && assignstartDate <= assignmax) { return true;}
				if(assignmax == null && assignstartDate >= assignmin) {return true;}
				if (assignstartDate <= assignmax && assignstartDate >= assignmin) { return true; }
				return false; 
			}
			);
			$("#assignmin").datepicker({ 
				onSelect: function () { assigntable.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#assignmax").datepicker({
				onSelect: function () { assigntable.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			var assigntable = $('#completed_table_id').DataTable({
				stateSave: true,
				dom: 'lBfrtip',
				lengthMenu: [
					[ 10, 25, 50, -1 ],
					[ '10', '25', '50', 'All' ]
				],
				language: {
							search: "",
							searchPlaceholder: "Search",
							sLengthMenu: " _MENU_",
						},
				buttons: [{
					extend: 'excel',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
					},
					filename: function fred() { return "Completed" + Date.now(); },
				},/* {
					extend: 'pdf',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
					}
				}, {
					extend: 'csv',
					exportOptions: {
						columns: [0,1,2,3,4,5,6,7]
					},
					filename: function fred() { return "Completed" + Date.now(); },
				}*/ 
				],
				<?php 
					if(!empty($usersessiondata)){
					//if($usersessiondata['user_type'] != 'consultant'){
				?>
				initComplete: function () {
					this.api().columns(3).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Category-</option></select>')
							.appendTo( $('.FilterCustom1').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
					this.api().columns(4).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">- Subcategory-</option></select>')
							.appendTo( $('.FilterCustom2').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
				<?php } //} ?>
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			});
			$('#assignmin, #assignmax').change(function () {
				assigntable.draw();
			});
		<?php
			}		
			if($this->uri->segment(2) == 'assign'){
		?>
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var assignmin = $('#assignmin').datepicker("getDate");
				var assignmax = $('#assignmax').datepicker("getDate");
				<?php 
					if(!empty($usersessiondata)){
					if($usersessiondata['user_type'] == 'consultant'){
				?>
					var newdate 	= data[12].split("-").reverse().join("-");
				<?php }else{ ?>
					var newdate 	= data[8].split("-").reverse().join("-");
				<?php } } ?>
				var assignstartDate = new Date(newdate);
				if(assignmax != null){
					assignmax.setDate(assignmax.getDate() + 1);
					assignmax.setSeconds(assignmax.getSeconds() - 1);
				}
				if (assignmin == null && assignmax == null) { return true; }
				if (assignmin == null && assignstartDate <= assignmax) { return true;}
				if(assignmax == null && assignstartDate >= assignmin) {return true;}
				if (assignstartDate <= assignmax && assignstartDate >= assignmin) { return true; }
				return false; 
			}
        );
		$("#assignmin").datepicker({ 
			onSelect: function () { assigntable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#assignmax").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#assignmax").datepicker({
			onSelect: function () { assigntable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#assignmin").datepicker("option", "maxDate", selectedDate);
			}
		});
		var assigntable = $('#assignticket_table_id').DataTable({
			stateSave: true,
			dom: 'lBfrtip',
			lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10', '25', '50', 'All' ]
            ],
            language: {
                        search: "",
                        searchPlaceholder: "Search",
                        sLengthMenu: " _MENU_",
                    },
			<?php 
				if(!empty($usersessiondata)){
				if($usersessiondata['user_type'] == 'consultant'){
			?>
			columnDefs: [
			   { type: 'de_datetime', targets: 17 }
			 ],
			order: [[ 17, "desc" ]],
			<?php }else{ ?>
			columnDefs: [
			   { type: 'de_datetime', targets: 12 }
			 ],
			order: [[ 13, "desc" ]],
			<?php }} ?>
			buttons: [{
				extend: 'excel',
				exportOptions: {
					<?php 
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						columns: [0,1,2,3,4,5,7,8,9,10,11,12,14,15]
					<?php }else{ ?>
						columns: [0,1,3,4,5,6,7,8,10,11]
					<?php }}  ?>
				},
				filename: function fred() { return "Assigned" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					<?php
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						columns: [0,1,2,3,4,5,7,8,9,10,11,12,14,15]
					<?php }else{ ?>
						columns: [0,1,3,4,5,6,7,8,10,11]
						<?php } } ?>
				},
				orientation: 'landscape',
                pageSize: 'LEGAL'
			}, {
				extend: 'csv',
				exportOptions: {
					<?php 
						if(!empty($usersessiondata)){
						if($usersessiondata['user_type'] == 'consultant'){
					?>
						columns: [0,1,2,3,4,5,7,8,9,10,11,12,14,15]
					<?php }else{ ?>
						columns: [0,1,3,4,5,6,7,8,10,11]
					<?php } } ?>
				},
				filename: function fred() { return "Assigned" + Date.now(); },
			}*/
			],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			initComplete: function () {
				<?php 
					if(!empty($usersessiondata)){
					if($usersessiondata['user_type'] == 'consultant'){
				?>
					var catcolumn = '10';
				<?php }else{ ?>
					var catcolumn = '6';
				<?php } } ?>
					this.api().columns(catcolumn).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- Category-</option></select>')
						.appendTo( $('.FilterCustom1').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );				
									
					column.data().unique().sort().each( function ( d, j ) {
						if(d != 'NA'){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				<?php 
					if(!empty($usersessiondata)){
					if($usersessiondata['user_type'] == 'consultant'){
				?>
					var subcatcolumn = '11';
				<?php }else{ ?>
					var subcatcolumn = '7';
				<?php } } ?>
					this.api().columns(subcatcolumn).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- Subcategory-</option></select>')
						.appendTo( $('.FilterCustom2').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );				
									
					column.data().unique().sort().each( function ( d, j ) {
						if(d != 'NA'){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				<?php 
					if(!empty($usersessiondata)){
					if($usersessiondata['user_type'] == 'consultant'){
				?>
					var statuscolumn = '14';
				<?php }else{ ?>
					var statuscolumn = '10';
				<?php } } ?>
					this.api().columns(statuscolumn).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">- Status-</option></select>')
						.appendTo( $('.FilterCustom3').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );	
					column.data().unique().sort().each( function ( d, j ) {					
						if(d != 'NA'){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
			}
		});
	//});
	$('#assignmin, #assignmax').change(function () {
		assigntable.draw();
	});
	<?php } ?>
	function chatListScroll(){
		var height = 0;
		$('.direct-chat-messages .direct-chat-msg').each(function(i, value){
			height += parseInt($(this).height());
		});
		height += height+250;
		$('.direct-chat-messages').animate({scrollTop: height+ 'px'});
	}
	
	var $message 	= '';
	var $imageFile 	= '';
	$('form#create-conversation button').click(function(){
		$("form#create-conversation").submit();
	});
	$('form#create-conversation').submit(function(event) {
		event.preventDefault();
		$('#uploaded-file').html('');
		createChatMassege();
	});
	function createChatMassege($message,$imageFile){
		/* var form_data = new FormData();
		if($("#upload_file").val() != ""){
			var file_data = $('#upload_file').prop('files')[0];
				form_data.append('upload_file', file_data);
		}
		form_data.append('message', $('#message').val());
		var chatticketid = $('#chatticketid').val();
		form_data.append('ticketid', chatticketid);
		form_data.append('flag', 'callajax'); */
		
		if($("#upload_file").val() != ""){
			var file_data = $('#upload_file').prop('files')[0];
		}
		var form_data = new FormData();
		form_data.append('upload_file', file_data);
		form_data.append('message', $('#message').val());
		var chatticketid = $('#chatticketid').val();
		form_data.append('ticketid', chatticketid);
		form_data.append('flag', 'callajax');
		
		$.ajax({
			type: "POST",
			//url: window.location.href,
			url: '<?php echo base_url();?>users/customerController/getchatdata',
			data: form_data,
			async: false,
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function(){
				$('form#create-conversation button').attr('disabled',true).text('Wait...');
			},
			success:function(response){
				$('#message').val('');
				$('#upload_file').val('');
				var obj = JSON.parse(response);
				$(".chat-success-msg-sent").html(obj.massege).css("color",obj.style_color).show();
				setTimeout(function () {
					$(".chat-success-msg-sent").hide();
				}, 2000);
				//$(".direct-chat-messages").last().append(obj.datalist);
				//$("#MsgBox .direct-chat-msg").last().append(obj.datalist);
				//chatListScroll();
				$('form#create-conversation button').attr('disabled',false).text('Send');
				$("#inners").animate({ scrollTop: 350 }, 1000);
			}
		});
	}
	<?php  
		$last = end($this->uri->segments);
		if ($last != 'login'){
	?>
		setInterval(function(){ 
			var chatdatashigh = $('#lastid').val();
			var chatticketid = $('#chatticketid').val();
			$.ajax({
				type: "POST",
				url: '<?php echo base_url();?>users/customerController/getnewchat',
				data: {'chatdatashigh':chatdatashigh,'chatticketid':chatticketid},
				beforeSend: function(){
					$('form#create-conversation button').attr('disabled',true).text('Wait...');
				},
				success:function(response){
					if(response != ''){
						var obj = JSON.parse(response);
						//console.log(obj);return false;
						//$("#MsgBox .direct-chat-msg").last().append(obj.datalist);
						$("#MsgBox").last().append(obj.datalist);
						$('#lastid').val(obj.lastid);
						var chatcount = $('#countchat').html();
						if(chatcount == ''){
							chatcount = 0;
						}
						if(obj.countchat > 0){
							var newcount = parseInt(chatcount)+ parseInt(obj.countchat);
							$('#countchat').html(newcount);
						}
					}
				},
				error:function(){
					console.log('error');
				}
			});
		}, 3000); 
	<?php } ?>
	$("#upload_file").change(function(e) {
		var file = this.files[0];
		var fileType = file.type;
		 var fileSize = file.size;
		var match= ["doc","pdf","docx","txt","jpg","png","jpeg"];
		
		if( fileSize > 2048000)	{
			 $(".chat-success-msg-sent-img").html('Filesize must 2mb or below.').css("color",'red').show();
			$(this).val('');
			return false;
		}	
		
		if($.inArray($(this).val().split('.').pop().toLowerCase(), match) === -1){
			$(".chat-success-msg-sent-img").html('Please select valid file.').css("color",'red').show();
			$(this).val('');
			return false;
		}
	});
   
	var $selected = '';
	$(document).ready(function() {
		var $countryid= $('.select-state').val();
		var $sectionid= $('.select-state').data('section');
		$selected = $('.select-state').data('stateid');
		if($countryid!=="" && $sectionid!==""){
			getstateList($countryid,$sectionid, $selected);
		};
	});

	$('.select-state').on('change',function(){
		getstateList($(this).val(), $(this).data('section'),$selected);
	});

	function getstateList($countryId,$from,$selected){
		var $selectedd = $selected;
		$.ajax({
			method: "POST",
			url: $base_url+'users/customerController/stateList',
			data: {"countryId":$countryId},
			success:function(response){
				var obj = JSON.parse(response);
				var listItem = "<option value=''>Select State</option>";
				if(obj.status===true && obj.data!==''){
					$.each(obj.data, function (index, value) {
						if(parseInt(value.id)===parseInt($selectedd)){
							$selected='selected="selected"'; 
						}else{
							$selected ="";
						}
						listItem += "<option value='"+value.id+"' "+$selected+">"+value.name+"</option>";
					});
				}else{
					listItem += "<option value='' selected>"+obj.massege+"</option>";
				}
				$("#"+$from).html(listItem);
			}
		});
	} 
	
	$(document).on('click', '.toChange', function () {
		var $url = $(this).data('url');
		var $action = $(this).data('action');
		var $id = $(this).data('id');
		var $msg = $(this).data('massege');
		var $ststus = $(this).data('status');
		if (confirm($msg)) {
			$.ajax({
				method: "POST",
				url: $url,
				data: {"uid": $id, "status": $ststus, "action": $action},
				success: function (response) {
					var obj = JSON.parse(response);
					alert(obj.message);
					setTimeout(function () {
						window.location.reload()
					}, 1000);
				}
			});
		}
	});
	$("#agent_assign_date").datepicker({
		dateFormat: "dd-mm-yy",
		minDate: 0
	});
	$(".datepicker").datepicker({
		dateFormat: "dd-mm-yy",
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true,
		maxDate: '+15D',
		yearRange: "-70:+0",
	});
	
	$(".datepickerdob").datepicker({
		dateFormat: "dd-mm-yy",
		maxDate: '<?php $date = strtotime(date("Y-m-d").' -18 year'); echo date('d-m-Y', $date); ?>',
		// showButtonPanel: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		changeMonth: true,
		changeYear: true
	   
	});

	$(document).on('click', '.has-treeview', function () {
		$(this).siblings('li').removeClass('menu-open');
		$(this).siblings('li').children('ul').hide();
	});
function post_rating() {
    var blogid = $('#blog_id').val();
    var comment_rating = $('#comment_rating').val();
    var starcount = $star_rating.siblings('input.rating-value').val();
    if (starcount&&comment_rating) {
    $.ajax({
        url: "main/rating",
        data: {starcount: starcount, blogid: blogid, comment_rating: comment_rating},
        type: "POST",
        success: function (data) {

            location.reload();

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('error in insert rating data');
        }
    });
    }else{
        alert("Please rate and comment");
    }

}
var $star_rating = $('.star-rating .fa');
var SetRatingStar = function() {
    return $star_rating.each(function() {
    if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
		return $(this).removeClass('fa-star-o').addClass('fa-star');
    } else {
        return $(this).removeClass('fa-star').addClass('fa-star-o');
    }
});

};
// alert($star_rating.siblings('input.rating-value').val());

$star_rating.on('click', function() {
    $star_rating.siblings('input.rating-value').val($(this).data('rating'));
    return SetRatingStar();
});

 function confirm_rating(action, ticket_id)
{	
	var form = document.getElementById('ratingForm' + ticket_id);
	if(form.elements["rating"].value == 0){
		alert("Please select star to rate!");
		return false;
	}
	form.action = action;
	document.getElementById("rateformsubmit").disabled = true; 
	form.submit();   
} 
    /********** 07012020 start ***********/
    $(document).ready(function(){
        $( "#message,#upload_file" ).focus(function() {
			var pathname = window.location.pathname; 
			var res = pathname.split("/");
			var last_res = res[res.length-1];
			$.ajax({
                url: '<?php echo base_url();?>users/customerController/changereadstatus',
                type: "post",
                data: {'ticketid':last_res},
                success: function(response){ 
					var chatticketid = $('#chatticketid').val();
					$("#notification_list").html('<div class="dropdown-divider"></div><p>No Record Available</p>');
					$("#countchat").html('0');
					console.log('Read successfully');
				},
				error:function(){
					console.log('error'); 
				}
            }); 
			//console.log('ok');return false;
        });
		function alpha(e) {
            var k;
            document.all ? k = e.keyCode : k = e.which;
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32);
        }
    });

    /********** 07012020  end ***********/
	
    /********** 09012020  start ***********/
	$(window).bind("load", function() {
		var start = $('#chatcountstart').val();
		var count = $('#chatcountlimit').val();
		var lastid = $('#lastid').val();
		lastid = parseInt(lastid) + 1;
		search(count,start,lastid);
		$("#inners").animate({ scrollTop: 350 }, 1000);
	});
	$(document).ready(function(){
		var inners = $("#inners")[0];
		if( typeof inners == 'undefined' ){
			console.log(inners);return false;
		}else{
			$("#inners").scrollTop(inners.scrollHeight);
			$('#inners').scroll(function(){
				if ($('#inners').scrollTop() == 0){
					var nochat = $('#nochat').val();
					if(nochat == '0'){
						$('#loader').show();
						setTimeout(function(){
						var start = $('#chatcountstart').val();
						var count = $('#chatcountlimit').val();	
						var chatdataslow = $('#chatdataslow').val();
						//alert(count+','+start+','+chatdataslow);
						search(count,start,chatdataslow);
						$('#loader').hide();
						$('#inners').scrollTop(30);
						},780);
					}				
				}
			}); 
		}
		$("#inners").scroll(function() {
			//var height = $(this)[0].scrollHeight;
			var heights = $(this).map(function ()
			{
				return $(this).height();
			}).get();
			var maxHeight = Math.max.apply(null, heights);
			if(maxHeight == '295'){
				var chatticketid = $('#chatticketid').val();
				$.ajax({
					url: '<?php echo base_url();?>users/customerController/changereadstatus',
					type: "post",
					data: {'ticketid':chatticketid},
					success: function(response){ 
						var chatticketid = $('#chatticketid').val();
						$("#notification_list").html('<div class="dropdown-divider"></div><p>No Record Available</p>');
						$("#countchat").html('0');
						console.log('Read successfully');
					},
					error:function(){
						console.log('error'); 
					}
				});
			}				
		});
	});
	function search(count,start,lastid){
		var last_res = $('#chatticketid').val();
		$.ajax({
			url: '<?php echo base_url();?>users/customerController/getchatdata',
			type: "post",
			data: {'ticketid':last_res,'count':count,'start':start,'lastid':lastid},
			success: function(data){ 
				if(data == ''){
					var nochat = $('#nochat').val('1');
				}
				$('#MsgBox').prepend(data);
				var newstart = parseInt(count) + parseInt(start);
				var last_res = $('#chatcountstart').val(newstart);
			},
			error:function(){
				console.log('error'); 
			}
		}); 
	}
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	<?php  
		$last = end($this->uri->segments);
		if ($last != 'login'){
	?>
	setInterval(function(){ 
		var chatdatashigh = $('#lastid').val();
		//var chatticketid = $('#chatticketid').val();
		$.ajax({
			type: "POST",
			url: '<?php echo base_url();?>users/customerController/getnewnotification',
			//dataType : "json",
			//contentType: "application/json; charset=utf-8",
			//data: {'chatdatashigh':chatdatashigh,'chatticketid':chatticketid},
			data: {'chatdatashigh':'chatdatashigh'},
			beforeSend: function(){
				$('form#create-conversation button').attr('disabled',true).text('Wait...');
			},
			success:function(response){
				//console.log(response);return false;
				if(response != ''){
					var obj = JSON.parse(response);
					$("#notification_list").html(obj.datalist);
					$("#countchat").html(obj.countchat);
				}
			},
			error:function(){
				console.log('error');
			}
		});
	}, 3000);
	<?php } ?>
    /********** 09012020  end ***********/
	$(function(){ 
		$("#category_id").change(function(){
			var $option = $(this).find('option:selected');
			var catId = $option.val();	  
			$.ajax({
				url: '<?php echo base_url();?>users/customerController/getsubcatbycat',
				data: {'catId': catId}, 
				type: "post",
				success: function(data){
					$("#subcategory_id").html(data);
				}
			});
		});
		$("#qualification").change(function(){
			var $option = $(this).find('option:selected');
			var qualId 	= $option.val();	  
			$.ajax({
				url: '<?php echo base_url();?>users/customerController/getsubqualbyqualid',
				data: {'qualId': qualId}, 
				type: "post",
				success: function(data){
					$("#sub_qualification").html(data);
				}
			});
		});
		$("#edit_state").change(function(){ 
			var $option = $(this).find('option:selected');
			var stateId = $option.val();
			$.ajax({
				url: '<?php echo base_url();?>users/customerController/getCityListdata',
				data: {'stateId': stateId}, 
				type: "post",
				success: function(data){
					$("#user_city").html(data);
				}
			});
		});
		$(".input").focus(function() {
            $(this).parent().addClass("focus");
        })
	});
	
</script>
    </body>
</html>
