<table id="remark_table" class="table table-bordered table-striped" style="width:100%;">
	<thead>
		<tr>
			<th>#</th>
			<th>Ticket</th>
			<th>Customer Detail</th>
			<th style="display:none;">Customer Name</th>
			<th style="display:none;">Customer Email</th>
			<th style="display:none;">Customer Phone</th>
			<th>Remark</th>
		</tr>
	</thead>
	<tbody>
		<?php
			if(!empty($remarks)){
				$counter 	= 1; 
				foreach($remarks as $remark){
					$ticketdetail 	= $this->ticket_model->getTicketById($remark->ticket_id);
					$customerdetail = $this->user_model->getCustomer($remark->customer_id);
					if(!empty($ticketdetail)){
						$ticket_id 		= $ticketdetail->ticket_id;
					}else{
						$ticket_id 		= '';					
					}
					if(!empty($customerdetail)){
						$name 		= $customerdetail->name;
						$email 		= $customerdetail->email;
						$mobile 	= $customerdetail->mobile;
						$alldetail	= $customerdetail->name . '<br/>' . $customerdetail->email . '<br/>' . $customerdetail->mobile;
					}else{
						$name 		= '';					
						$email 		= '';					
						$mobile		= '';	
						$alldetail	= '';
					}
		?>
			<tr>
				<td><?php echo $counter; ?></td>
				<td><?php echo $ticket_id; ?></td>
				<td><?php echo $alldetail; ?></td>
				<td style="display:none;"><?php echo $name; ?></td>
				<td style="display:none;"><?php echo $email; ?></td>
				<td style="display:none;"><?php echo $mobile; ?></td>
				<td><?php echo isset($remark->review)?$remark->review:''; ?></td>
			</tr>
		<?php $counter++; } }else{ ?>
			<p></p>
		<?php } ?>
	</tbody>
</table>
<script>
$(document).ready(function(){
	$('#remark_table').DataTable({
		dom: 'Bfrtip',
		buttons: [{
			extend: 'excel',
			exportOptions: {
				columns: [0,1,3,4,5,6]
			}
		},{
			extend: 'csv',
			exportOptions: {
				columns: [0,1,3,4,5,6]
			}
		}],
		//"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
	});
});
</script>
