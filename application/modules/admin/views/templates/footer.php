<?php
if ((!empty($this->session->userdata('admins')['user_id']))) {
    echo '<footer class="main-footer">
            <div class="float-right d-none d-sm-block">
              <b>HashTag Labs</b>
            </div>
            <strong>Copyright &copy; '.date("Y").' <a href="http://hashtaglabs.in/" target="_blank">HashTag Labs</a>.</strong> All rights
        reserved.
        </footer>
    </div>';
}
?>
<script src="<?php echo base_url() . 'cosmatics/plugins/bootstrap/js/bootstrap.bundle.min.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/plugins/fastclick/fastclick.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/plugins/datatables/jquery.dataTables.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/plugins/datatables/dataTables.bootstrap4.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/js/adminlte.min.js';?>" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/js/base64_encode.js' ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/js/app.js'; ?>" type="text/javascript"></script> 
<script src="<?php echo base_url() . 'cosmatics/validation/jquery.validate.min.js'; ?>" type="text/javascript"></script> 
<script src="<?php echo base_url() . 'cosmatics/validation/additional-methods.js'; ?>" type="text/javascript"></script> 
<script src="<?php echo base_url() . 'cosmatics/validation/email-validation.js'; ?>" type="text/javascript"></script>
<script src="<?php echo base_url() . 'cosmatics/validation/custom.js'; ?>" type="text/javascript"></script> 

<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
<script>
    var $base_url = "<?php echo base_url();?>";
    function hideSuccessMsg(){
        $('.alert-dismissible').hide();
    }
    
    $(function () {
        setTimeout(function() {
            hideSuccessMsg()
        }, 4000);
        $("#example1").DataTable();
    });
    
    $(document).ready(function () {
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

            buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,2,3,4,5,6]
				},
				filename: function fred() { return "Filenotice" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,3,4,5,6]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2,3,4,5,6]
				},
				filename: function fred() { return "Filenotice" + Date.now(); },
			}],
			initComplete: function () {
            this.api().columns(2).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">Category</select>')
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
					if(d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
        }
        });
		$('#certificate_table').DataTable({
             stateSave: true,
             dom: 'Bfrtip',
            // lengthMenu: [
            //     [ 10, 25, 50, -1 ],
            //     [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            // ],
            buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1]
				},
				filename: function fred() { return "Filenotice" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,3,4,5,6]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1]
				},
				filename: function fred() { return "Filenotice" + Date.now(); },
			}],
        });
		
		/***** Completed Ticket DataTable ************/
		<?php 
			if($this->uri->segment(3) == 'completed_list'){
		?>
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var completemin = $('#completemin').datepicker("getDate");
				var completemax = $('#completemax').datepicker("getDate");
				var newdate 	= data[16].split("-").reverse().join("-");
				if(completemax != null){
					completemax.setDate(completemax.getDate() + 1);
					completemax.setSeconds(completemax.getSeconds() - 1);
				}
				var assignstartDate = new Date(newdate);
				if (completemin == null && completemax == null) { return true; }
				if (completemin == null && assignstartDate <= completemax) { return true;}
				if(completemax == null && assignstartDate >= completemin) {return true;}
				if (assignstartDate <= completemax && assignstartDate >= completemin) { return true; }
				return false; 
			}
        );
		$("#completemin").datepicker({ 
			onSelect: function () { completetable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#completemax").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#completemax").datepicker({
			onSelect: function () { completetable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#completemin").datepicker("option", "maxDate", selectedDate);
			}
		});
		
		var completetable = $('#completed_table_id').DataTable({
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
					columns: [0,2,3,4,5,7,8,10,11,12,14,15,16]
				},
				filename: function fred() { return "Completedticket" + Date.now(); },
			} ,/*{
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,3,4,5,7]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,2,3,4,5,7,8,10,11,12,14,15,16]
				},
				filename: function fred() { return "Completedticket" + Date.now(); },
			}],
			initComplete: function () {
				this.api().columns(7).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Category</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(8).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(10).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">State</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(11).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">City</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
			}
        });
		$('#completemin, #completemax').change(function () {
			completetable.draw();
		});
		<?php } ?>
		/***** Completed Ticket DataTable ************/
		
		$('#rating_table_id').DataTable({
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
					columns: [0,1,3,4,5,6,7,8,9,11]
				},
				filename: function fred() { return "Rating" + Date.now(); },
			},/*{
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8,9,11]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8,9,11]
				},
				filename: function fred() { return "Rating" + Date.now(); },
			}],
			initComplete: function () {
				this.api().columns(6).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Category</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(7).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(8).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">State</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(9).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">City</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
			}
        });
		
		/**** assign ticket datatable ****/
		<?php 
			if($this->uri->segment(3) == 'assign_list'){
		?>
		/* var totalSUM = 0, minDate, maxDate;
		$("#assignedticket_table_id tbody tr").each(function() {
			var getTotal = $(this).find("td:eq(1)").text(),
			date = $(this).find("td:eq(17)").text();
			totalSUM += Number(getTotal);
			minDate = !minDate || date < minDate ? date : minDate;
			maxDate = !maxDate || date > maxDate ? date : maxDate;
		});
		minDate = new Date(Date.parse(minDate));
		maxDate = new Date(Date.parse(maxDate));
		var minimumdate = new Date(new Date(minDate).getDate()+"-"+(new Date(minDate).getMonth())+"-"+(new Date(minDate).getFullYear()));
		console.log(minimumdate);
		var maximumdate = new Date(new Date(maxDate).getDate()+"-"+(new Date(maxDate).getMonth())+"-"+(new Date(maxDate).getFullYear())); */
		
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var assignmin = $('#assignmin').datepicker("getDate");
				var assignmax = $('#assignmax').datepicker("getDate");
				var newdate 	= data[17].split("-").reverse().join("-");
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
		var assigntable = $('#assignedticket_table_id').DataTable({
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
					columns: [0,1,3,4,5,7,8,9,11,12,14,15,17,18,20]
				},
				filename: function fred() { return "Assigned" + Date.now(); },
			},{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,5,7,8,9,11,12,14,15,17,18,20]
				},
				filename: function fred() { return "Assigned" + Date.now(); },
			}],
			initComplete: function () {
            this.api().columns(11).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">Category</select>')
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
					if(d != 'NA' && d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			this.api().columns(12).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
					if(d != 'NA' && d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			this.api().columns(14).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">State</select>')
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
					if(d != 'NA' && d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			this.api().columns(15).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">City</select>')
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
					if(d != 'NA' && d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
			this.api().columns(20).every( function () {
                var column = this;
				var val = '';
                var select = $('<select class="form-control"><option value="">Status</select>')
                    .appendTo( $('.FilterCustom5').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );	
                column.data().unique().sort().each( function ( d, j ) {					
					if(d != 'NA' && d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
        }
        });
		$('#assignmin, #assignmax').change(function () {
			assigntable.draw();
		});
		<?php } ?>
		/**** assign ticket datatable ****/
		
		$('#experties_table_id').DataTable({
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

            // lengthMenu: [
            //     [ 10, 25, 50, -1 ],
            //     [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            // ],
            buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,3]
				},
				filename: function fred() { return "Experties" + Date.now(); },
			},/*{
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,3]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3]
				},
				filename: function fred() { return "Experties" + Date.now(); },
			}]
        });
		$('#ticket_status_table').DataTable({
			stateSave: true,
			dom: 'Bfrtip',
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,2,4,5,6,8,9]
				},
				filename: function fred() { return "Ticketstatus" + Date.now(); },
			},/*{
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,4,5,6,8,9]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2,4,5,6,8,9]
				},
				filename: function fred() { return "Ticketstatus" + Date.now(); },
			}],
			/* columnDefs: [
			   { type: 'de_datetime', targets: 8 }
			 ],
			order: [[ 8, "desc" ]], */
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$('#category_table_id').DataTable({
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
					columns: [0,1,2,4]
				},
				filename: function fred() { return "Category" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,4]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2,4]
				},
				filename: function fred() { return "Category" + Date.now(); },
			}]
        });
		$('#subcategory_table_id').DataTable({
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

            // lengthMenu: [
            //     [ 10, 25, 50, -1 ],
            //     [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            // ],
            buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,2,3,5]
				},
				filename: function fred() { return "Subategory" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,2,3,5]
				}
			}, */{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,2,3,5]
				},
				filename: function fred() { return "Subategory" + Date.now(); },
			}]
        });
		<?php 
			if($this->uri->segment(3) == 'customer_request'){
		?>
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var requestmin 	= $('#requestmin').datepicker("getDate");
				var requestmax 	= $('#requestmax').datepicker("getDate");
				var newdate 	= data[15].split("-").reverse().join("-");
				if(requestmax != null){
					requestmax.setDate(requestmax.getDate() + 1);
					requestmax.setSeconds(requestmax.getSeconds() - 1);
				}
				var requeststartDate = new Date(newdate);
				if (requestmin == null && requestmax == null) { return true; }
				if (requestmin == null && requeststartDate <= requestmax) { return true;}
				if(requestmax == null && requeststartDate >= requestmin) {return true;}
				if (requeststartDate <= requestmax && requeststartDate >= requestmin) { return true; }
				return false; 
			}
        );
		$("#requestmin").datepicker({ 
			onSelect: function () { requesttable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#requestmax").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#requestmax").datepicker({
			onSelect: function () { requesttable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#requestmin").datepicker("option", "maxDate", selectedDate);
			}
		});
		var requesttable = $('#customerrequest_table_id').DataTable({
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
					columns: [0,1,3,4,6,7,9,10,11,12,13,14]
				},
				filename: function fred() { return "Customerrequest" + Date.now(); },
			},/* {
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8]
				}
			} ,*/{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,6,7,9,10,11,12,13,14]
				},
				filename: function fred() { return "Customerrequest" + Date.now(); },
			}],
			initComplete: function () {
				this.api().columns(3).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Category</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(4).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(6).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">State</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(7).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">City</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
			}
        });
		$('#requestmin, #requestmax').change(function () {
			requesttable.draw();
		});
		<?php } ?>
		/**** Unassigned Ticket DataTable *********/
		<?php 
			if($this->uri->segment(3) == 'ticket_list'){
		?>
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				var unassignmin = $('#unassignmin').datepicker("getDate");
				var unassignmax = $('#unassignmax').datepicker("getDate");
				var newdate 	= data[12].split("-").reverse().join("-");
				if(unassignmax != null){
					unassignmax.setDate(unassignmax.getDate() + 1);
					unassignmax.setSeconds(unassignmax.getSeconds() - 1);
				}
				var assignstartDate = new Date(newdate);
				if (unassignmin == null && unassignmax == null) { return true; }
				if (unassignmin == null && assignstartDate <= unassignmax) { return true;}
				if(unassignmax == null && assignstartDate >= unassignmin) {return true;}
				if (assignstartDate <= unassignmax && assignstartDate >= unassignmin) { return true; }
				return false; 
			}
        );
		$("#unassignmin").datepicker({ 
			onSelect: function () {unassigntable.draw();},
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#unassignmax").datepicker("option", "minDate", selectedDate);
			}
		});
		$("#unassignmax").datepicker({
			onSelect: function () { unassigntable.draw(); },
			changeMonth: true, 
			changeYear: true ,
			dateFormat: 'dd-mm-yy',
			onClose: function (selectedDate) {
				$("#unassignmin").datepicker("option", "maxDate", selectedDate);
			}
		});
		
		var unassigntable = $('#ticket_table_id').DataTable({
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
				this.api().columns(7).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Category</select>')
						.appendTo( $('.customfiltercategory').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(8).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Subcategory</select>')
						.appendTo( $('.customfiltersubcategory').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(10).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">State</select>')
						.appendTo( $('.customfiltercity').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(11).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">City</select>')
						.appendTo( $('.customfilterstate').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );
	 
					column.data().unique().sort().each( function ( d, j ) {
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
			},
			buttons: [{
				extend: 'excel',
				exportOptions: {
					columns: [0,1,3,4,5,7,8,10,11,12,15]
				},
				filename: function fred() { return "Ticket" + Date.now(); },
			},{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,5,7,8,10,11,12,15]
				},
				filename: function fred() { return "Ticket" + Date.now(); },
			}],
			//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
		});
		$('#unassignmin, #unassignmax').change(function () {
			unassigntable.draw();
		});
		<?php } ?>
		/****** Unassigned Ticket DataTable ***************/
		
		$('#consultant_table_id').DataTable({
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
					columns: [0,1,3,4,5,6,8,9,10,11]
				},
				filename: function fred() { return "Allconsultant" + Date.now(); },
			}/* ,{
				extend: 'pdf',
				exportOptions: {
					columns: [0,1,3,4,5,6,7,8,9,10,11]
				}
			} */,{
				extend: 'csv',
				exportOptions: {
					columns: [0,1,3,4,5,6,8,9,10,11]
				},
				filename: function fred() { return "Allconsultant" + Date.now(); },
			}],
			initComplete: function () {
				this.api().columns(1).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Account Type</select>')
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
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(8).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Category</select>')
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
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				/* this.api().columns(8).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} ); */
				this.api().columns(9).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">State</select>')
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
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(10).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">City</select>')
						.appendTo( $('.FilterCustom5').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );				
									
					column.data().unique().sort().each( function ( d, j ) {
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(12).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Status</select>')
						.appendTo( $('.FilterCustom6').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
	 
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );				
									
					column.data().unique().sort().each( function ( d, j ) {
						if(d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
        }
        });
		
		/**** New Ticket list page datatable 06072020 *******/
		<?php  
			if(isset($status)){
				if($status == '10' ){ 
		?>
			$.fn.dataTable.ext.search.push(
				function (settings, data, dataIndex) {
					var unassignmin = $('#unassignmin').datepicker("getDate");
					var unassignmax = $('#unassignmax').datepicker("getDate");
					var newdate 	= data[12].split("-").reverse().join("-");
					if(unassignmax != null){
						unassignmax.setDate(unassignmax.getDate() + 1);
						unassignmax.setSeconds(unassignmax.getSeconds() - 1);
					}
					var assignstartDate = new Date(newdate);
					if (unassignmin == null && unassignmax == null) { return true; }
					if (unassignmin == null && assignstartDate <= unassignmax) { return true;}
					if(unassignmax == null && assignstartDate >= unassignmin) {return true;}
					if (assignstartDate <= unassignmax && assignstartDate >= unassignmin) { return true; }
					return false; 
				}
			);
			$("#unassignmin").datepicker({ 
				onSelect: function () {ticketlist_table.draw();},
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#unassignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#unassignmax").datepicker({
				onSelect: function () { ticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#unassignmin").datepicker("option", "maxDate", selectedDate);
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
				initComplete: function () {
					this.api().columns(7).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Category</select>')
							.appendTo( $('.customfiltercategory').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(8).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Subcategory</select>')
							.appendTo( $('.customfiltersubcategory').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(10).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">State</select>')
							.appendTo( $('.customfiltercity').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(11).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">City</select>')
							.appendTo( $('.customfilterstate').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
				},
				buttons: [{
					extend: 'excel',
					exportOptions: {
						columns: [0,1,3,4,5,7,8,10,11,12,15]
					},
					filename: function fred() { return "Ticket" + Date.now(); },
				},{
					extend: 'csv',
					exportOptions: {
						columns: [0,1,3,4,5,7,8,10,11,12,15]
					},
					filename: function fred() { return "Ticket" + Date.now(); },
				}],
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			});
			$('#unassignmin, #unassignmax').change(function () {
				ticketlist_table.draw();
			});
		<?php }elseif($status == '20' ){ ?>
			$.fn.dataTable.ext.search.push(
				function (settings, data, dataIndex) {
					var assignmin = $('#assignmin').datepicker("getDate");
					var assignmax = $('#assignmax').datepicker("getDate");
					var newdate 	= data[17].split("-").reverse().join("-");
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
				onSelect: function () { assignedticket_list.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#assignmax").datepicker({
				onSelect: function () { assignedticket_list.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#assignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			var assignedticket_list = $('#assignedticket_list').DataTable({
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
						columns: [0,1,3,4,5,7,8,9,11,12,14,15,17,18,20]
					},
					filename: function fred() { return "Assigned" + Date.now(); },
				},{
					extend: 'csv',
					exportOptions: {
						columns: [0,1,3,4,5,7,8,9,11,12,14,15,17,18,20]
					},
					filename: function fred() { return "Assigned" + Date.now(); },
				}],
				initComplete: function () {
				this.api().columns(11).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Category</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(12).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(14).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">State</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(15).every( function () {
					var column = this;
					var select = $('<select class="form-control"><option value="">City</select>')
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
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
				this.api().columns(20).every( function () {
					var column = this;
					var val = '';
					var select = $('<select class="form-control"><option value="">Status</select>')
						.appendTo( $('.FilterCustom5').empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);
							column
								.search( val ? '^'+val+'$' : '', true, false )
								.draw();
						} );	
					column.data().unique().sort().each( function ( d, j ) {					
						if(d != 'NA' && d != ''){
							select.append( '<option value="'+d+'">'+d+'</option>' )
						}
					} );
				} );
			}
			});
			$('#assignmin, #assignmax').change(function () {
				assignedticket_list.draw();
			});
		<?php }elseif($status == '90'){ ?>
			$.fn.dataTable.ext.search.push(
				function (settings, data, dataIndex) {
					var completemin = $('#completemin').datepicker("getDate");
					var completemax = $('#completemax').datepicker("getDate");
					var newdate 	= data[16].split("-").reverse().join("-");
					if(completemax != null){
						completemax.setDate(completemax.getDate() + 1);
						completemax.setSeconds(completemax.getSeconds() - 1);
					}
					var assignstartDate = new Date(newdate);
					if (completemin == null && completemax == null) { return true; }
					if (completemin == null && assignstartDate <= completemax) { return true;}
					if(completemax == null && assignstartDate >= completemin) {return true;}
					if (assignstartDate <= completemax && assignstartDate >= completemin) { return true; }
					return false; 
				}
			);
			$("#completemin").datepicker({ 
				onSelect: function () { completed_list.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#completemax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#completemax").datepicker({
				onSelect: function () { completed_list.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#completemin").datepicker("option", "maxDate", selectedDate);
				}
			});
			
			var completed_list = $('#completed_list').DataTable({
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
						columns: [0,2,3,4,5,7,8,10,11,12,14,15,16]
					},
					filename: function fred() { return "Completedticket" + Date.now(); },
				} ,/*{
					extend: 'pdf',
					exportOptions: {
						columns: [0,1,2,3,4,5,7]
					}
				}, */{
					extend: 'csv',
					exportOptions: {
						columns: [0,2,3,4,5,7,8,10,11,12,14,15,16]
					},
					filename: function fred() { return "Completedticket" + Date.now(); },
				}],
				initComplete: function () {
					this.api().columns(7).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Category</select>')
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
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(8).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Subcategory</select>')
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
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(10).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">State</select>')
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
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(11).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">City</select>')
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
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
				}
			});
			$('#completemin, #completemax').change(function () {
				completed_list.draw();
			});
		<?php }else{ ?>
			$.fn.dataTable.ext.search.push(
				function (settings, data, dataIndex) {
					var unassignmin = $('#unassignmin').datepicker("getDate");
					var unassignmax = $('#unassignmax').datepicker("getDate");
					var newdate 	= data[12].split("-").reverse().join("-");
					if(unassignmax != null){
						unassignmax.setDate(unassignmax.getDate() + 1);
						unassignmax.setSeconds(unassignmax.getSeconds() - 1);
					}
					var assignstartDate = new Date(newdate);
					if (unassignmin == null && unassignmax == null) { return true; }
					if (unassignmin == null && assignstartDate <= unassignmax) { return true;}
					if(unassignmax == null && assignstartDate >= unassignmin) {return true;}
					if (assignstartDate <= unassignmax && assignstartDate >= unassignmin) { return true; }
					return false; 
				}
			);
			$("#unassignmin").datepicker({ 
				onSelect: function () {allticketlist_table.draw();},
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#unassignmax").datepicker("option", "minDate", selectedDate);
				}
			});
			$("#unassignmax").datepicker({
				onSelect: function () { allticketlist_table.draw(); },
				changeMonth: true, 
				changeYear: true ,
				dateFormat: 'dd-mm-yy',
				onClose: function (selectedDate) {
					$("#unassignmin").datepicker("option", "maxDate", selectedDate);
				}
			});
			
			var allticketlist_table = $('#allticketlist_table').DataTable({
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
					this.api().columns(7).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Category</select>')
							.appendTo( $('.customfiltercategory').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(8).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Subcategory</select>')
							.appendTo( $('.customfiltersubcategory').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(10).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">State</select>')
							.appendTo( $('.customfiltercity').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(11).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">City</select>')
							.appendTo( $('.customfilterstate').empty() )
							.on( 'change', function () {
								var val = $.fn.dataTable.util.escapeRegex(
									$(this).val()
								);
		 
								column
									.search( val ? '^'+val+'$' : '', true, false )
									.draw();
							} );
		 
						column.data().unique().sort().each( function ( d, j ) {
							if(d != 'NA' && d != ''){
								select.append( '<option value="'+d+'">'+d+'</option>' )
							}
						} );
					} );
					this.api().columns(16).every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value="">Status</select>')
							.appendTo( $('.customfilterstatus').empty() )
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
						columns: [0,1,3,4,5,7,8,10,11,12,15]
					},
					filename: function fred() { return "Ticket" + Date.now(); },
				},{
					extend: 'csv',
					exportOptions: {
						columns: [0,1,3,4,5,7,8,10,11,12,15]
					},
					filename: function fred() { return "Ticket" + Date.now(); },
				}],
				//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
			});
			$('#unassignmin, #unassignmax').change(function () {
				allticketlist_table.draw();
			});
		<?php } } ?>
		/**** New Ticket list page datatable 06072020 *******/
		
		
		
    });
	$(document).ready(function () {
        $('#customer_list').DataTable({
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
					columns: [0,2,3,4,5,6,7,8]
				},
				filename: function fred() { return "Customerlist" + Date.now(); },
			}/* ,{
				extend: 'pdf',
				exportOptions: {
					columns: [0,2,3,4,5,6,7,8]
				}
			} */,{
				extend: 'csv',
				exportOptions: {
					columns: [0,2,3,4,5,6,7,8]
				},
				filename: function fred() { return "Customerlist" + Date.now(); },
			}],
			initComplete: function () {
            this.api().columns(9).every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value="">Status</select>')
                    .appendTo( $('.Filterstatus').empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );				
								
                column.data().unique().sort(Ascending_sort).each( function ( d, j ) {
					if(d != ''){
						select.append( '<option value="'+d+'">'+d+'</option>' )
					}
                } );
            } );
        }
        });
    });
    
    var $selected = '';
    $(document).ready(function() {
        var $countryid= $('.select-state').val();
        var $sectionid= $('.select-state').data('section');
        var $selected = $('.select-state').data('stateid');
        if($countryid!=="" && $sectionid!==""){
            getstateList($countryid,$sectionid, $selected);
        }
    });
    
    $('.select-state').on('change',function(){
        getstateList($(this).val(), $(this).data('section'),$selected);
    });
    
    function getstateList($countryId,$from,$selected){
        var $selectedd = $selected
        $.ajax({
            method: "POST",
            url: $base_url+'admin/stateList',
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

    $(document).ready(function() {
//        var $countryid= $('.change-category').val();
//        var $sectionid= $('.change-category').data('section');
//        var $selected = $('.change-category').data('selectedid');
//        if($countryid!=="" && $sectionid!==""){
//            getstateList($countryid,$sectionid, $selected);
//        }
    });
    $('.change-category').on('change',function(){
        subcategoryList($(this).val(), $(this).data('section'),$selected);
    });
    function subcategoryList($categoryid,$from,$selected){
        $selectedd = $selected;
        var listItem = "<option value=''>Please Wait...</option>";
        $("#"+$from).html(listItem);
        $.ajax({
            method: "POST",
            url: $base_url+'admin/ticket/getsubcategory',
            data: {"category_id":$categoryid},
            success:function(response){
                var obj = JSON.parse(response);
                var listItem = "<option value=''>Select Sub-category</option>";
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
    
    $(document).on('click','.toChange',function() {
        var $url    = $(this).data('url');
        var $action = $(this).data('action');
        var $id     = $(this).data('id');
        var $msg    = $(this).data('massege');
        var $ststus = $(this).data('status');
        if(confirm($msg)){
            $.ajax({
                method: "POST",
                url: $url,
                data: {"uid":$id,"status":$ststus,"action":$action},
                success:function(response){
					//console.log(response);return false;
					if(response == 1){
						location.reload(true);
					}else{
						var obj = JSON.parse(response);
						alert(obj.message);
						setTimeout(function() {
							window.location.reload()
						}, 1000);
					}
                }
            });
        }
    });
	
    $(document).on('click','.toChangenew',function() {
        var $url    = $(this).data('url');
        var $action = $(this).data('action');
        var $id     = $(this).data('id');
        var $msg    = $(this).data('massege');
        var $ststus = $(this).data('status');
		var $email 	= $(this).data('email');
		var $name 	= $(this).data('name');
        if(confirm($msg)){
            $.ajax({
                method: "POST",
                url: $url,
                data: {"uid":$id,"status":$ststus,"action":$action,"email":$email,"name":$name},
                success:function(response){
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    setTimeout(function() {
                        window.location.reload()
                    }, 1000);
                }
            });
        }
    });
	$(document).on('click','.toChangeconsultant',function() {
        var $url    = $(this).data('url');
        var $action = $(this).data('action');
        var $id     = $(this).data('id');
        var $msg    = $(this).data('massege');
        var $ststus = $(this).data('status');
		var $email 	= $(this).data('email');
		var $name 	= $(this).data('name');
        if(confirm($msg)){
            $.ajax({
                method: "POST",
                url: $url,
                data: {"uid":$id,"status":$ststus,"action":$action,"email":$email,"name":$name},
                success:function(response){
                    var obj = JSON.parse(response);
                    alert(obj.message);
                    setTimeout(function() {
                        window.location.reload()
                    }, 1000);
                }
            });
        }
    });
	var today = new Date();
	$("#assign_date").datepicker({
        dateFormat: "dd-mm-yy",
		minDate: 0,
    });
	$("#start_date").datepicker({
        dateFormat: "dd-mm-yy",
		minDate: 0,
    });
	
    $(".datepicker").datepicker({
        dateFormat: "dd-mm-yy",
        // maxDate: '0',
        // showButtonPanel: true,
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
		yearRange: "-80:+0",
        showOtherMonths: true,
        selectOtherMonths: true,
        changeMonth: true,
        changeYear: true
       
    });

//    .datepicker("setDate", new Date())
    //$.datepicker._gotoToday = function(id) {
    //    var target = $(id);
    //    var inst = this._getInst(target[0]);
    //    var date = new Date();
    //    this._setDate(inst,date);
    //    this._hideDatepicker();
    //}
    
    $(document).on('click','.has-treeview', function(){
        $(this).siblings('li').removeClass('menu-open');
        $(this).siblings('li').children('ul').hide();
    });
	function Ascending_sort(a, b) { 
		return ($(b).text().toUpperCase()) <  
			($(a).text().toUpperCase()) ? 1 : -1;  
	} 
</script>
<script>
	$(document).ready(function(){ 
		var base_url = '<?php echo base_url(); ?>';
		//console.log(base_url);return false;
		$("#ad_qualification").change(function(){
			var $option = $(this).find('option:selected');
			var qualId 	= $option.val();
			$.ajax({
				url: base_url+'admin/consultant/getsubqualbyqualid',
				data: {'qualId': qualId}, 
				type: "post",
				success: function(data){
					$("#ad_sub_qualification").html(data);
				}
			});
		});
	});
	function alpha(e) {
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 );
    }
	$("#expertise_text").select2( {
		placeholder: "Select Expertise",
		allowClear: true,
		container:'body'
	} );
</script>
<script type="text/javascript">
        $(".input").focus(function() {
            $(this).parent().addClass("focus");
        })
     </script>
</body>
</html>