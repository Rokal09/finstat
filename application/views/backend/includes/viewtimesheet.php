
<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createtimesheet'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Timesheet Details
            </header>
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>ID</th>
					<th>User Name</th>
					<th>center</th>
					<th>Activity Name</th>
					<th>Activity type</th>
					<th>date</th>
					<th>view</th>
					<th>Time</th>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->id;?></td>
						<td><?php echo $row->firstname."&nbsp&nbsp".$row->lastname;?></td>
						<td><?php echo $row->centername;?></td>
						<td></td>
						<td><?php echo $row->activity;?></td>
						<td><?php echo $row->date;?></td>
						<td><a href="<?php echo site_url('site/viewtimesheet?id=').$row->id;?>" class="btn btn-info btn-xs">
								View more
							</a></td>
							<td></td>
						<td>
							<a href="<?php echo site_url('site/edittimesheet?id=').$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deletetimesheet?id=').$row->id; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
							
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
            
		</section>
	</div>
</div>