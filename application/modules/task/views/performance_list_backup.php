<?php include($this->config->item('header')); ?>
	<div class="content">
        <div class="page-header">
            <div class="icon">
                <span class="ico-arrow-right"></span>
            </div>
            <h1>Task</h1>
        	<?php echo "<div align='right'>".anchor("task/action/add/task","<input type='button' value='add new task' >")."</div>"; ?>
		</div>

      <!-- row title -->
      <div class="row">
        <div class="col-lg-12">
			<h4 class="page-title"><?php echo anchor('task/dashboard', 'TMS', 'title="Task Management System Dashboard"');?> <i class="fa fa-angle-double-right">TASK LIST</i> </h4>
		</div>
      </div>
      <!-- row -->
      
      <!-- row -->
      <div class="row-fluid">
        
        <!-- col -->
        <div class="span12 col-lg-12">
          
          <!-- widget -->
          <div class="block">
            <div class="data-fluid">
				<div class="row">
					<?php echo form_open("task/manage/performance"); ?>
					<div class="span6"></div>
					<div class="span2"> 
						<?php 
							$var_user[""]="";
							foreach($list_user as $lu){
								$usr = $this->encrypt->decode($lu->ui_nama,$this->config->item('encryption_key'));
								$var_user[$usr] = $usr;
							}
							echo form_dropdown("user",$var_user,"");
						?>
					</div>
					<div class="span1"> <?php echo form_input("start_date",""," id='inputStart' class='mask_date' placeholder='start date' "); ?></div>
					<div align="center" class="span1"> <?php echo "s/d"; ?></div>
					<div class="span1"> <?php echo form_input("end_date",""," id='inputStart' class='mask_date' placeholder='end date' "); ?></div>
					<div align="right" class="span1"> <?php echo form_submit("submit","Search"); ?></div>
					<?php echo form_close();?>
				</div>
				<div class="row"> <br><br></div>
			</div>
			<div class="head purple">
                <div class="icon"><span class="ico-location"></span></div>
                <h2>Task List</h2>     
                <ul class="buttons">
                    <li><a href="#" onClick="source('table_hover'); return false;"><div class="icon"><span class="ico-info"></span></div></a></li>
                </ul>
			</div>  
			
            <!-- wigget content -->
            <div class="data-fluid">
								
        			<?php if($this->session->userdata('logged_in')) { ?>
            		<?php if(isset($message)){echo '<div class="badge-warning"><p class="text-danger">&nbsp; message : '.$message.'</p></div>';} ?>
            		<?php if(validation_errors()){echo '<div class="badge-warning">'.validation_errors().'</div>';} ?>
                    <table cellpadding="0" cellspacing="0" width="100%" class="table table-hover">
                        <thead>
							<tr>
								<td>No</td>
								<td>Category</td>
								<td>Name</td>
								<td>Point</td>
								<td>Start</td>
								<td>Finish</td>
								<td>Duration</td>
								<td>Status</td>
								<td>By</td>
								<td>Performance</td>
							</tr>
						</thead>
                  	    <tbody>
							<?php 
							$i = 0;
							foreach($result as $row){ 
							$i++;
							$current = mdate('%Y-%m-%d %H:%i:%s',time());
							if($row->task_status == 'complete'){$bg = " style=' background-color: #CCFFCC' ";}
							else if(($row->task_status != 'complete') AND ($row->task_sch_finish < $current) AND ($row->task_act_finish == "0000-00-00 00:00:00")){$bg=" style=' background-color: #FFFFDD' ";}
							else if(($row->task_status == 'complete') AND ($row->task_sch_finish < $row->task_act_finish)){$bg=" style=' background-color: #FFDDDD' ";}
							else{$bg="";}
							
							?>
							<tr>
								<td rowspan="2" <?php echo "$bg";?>><?php echo $i;?></td>
								<td rowspan="2" <?php echo "$bg";?>><?php echo strtoupper($row->task_category);?></td>
								<td rowspan="2" <?php echo "$bg";?>><?php echo strtoupper($row->task_name);?></td>
								<td rowspan="2" <?php echo "$bg";?>><?php echo strtoupper($row->task_point);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_sch_start);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_sch_finish);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_sch_duration);?></td>
								<td rowspan="2" <?php echo "$bg";?>><?php echo strtoupper($row->task_status);?></td>
								<td rowspan="2" <?php echo "$bg";?>><?php echo strtoupper($row->task_update_by);?></td>
								<td rowspan="2" <?php echo "$bg";?>>
									<?php
									$performance = 0;
									if($row->task_status == "complete"){
										$duration = $row->task_act_duration - $row->task_sch_duration;
										if($duration < 0){ 
											$performance = $row->task_point;
										}elseif($duration == 0){
											$performance = 0;
										}else{
											$performance = (1 - ($duration / $row->task_sch_duration)) * $row->task_point;
										}
									}
									echo number_format($performance,0,',','.' );
									?>
								</td>
							</tr>
							<tr>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_act_start);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_act_finish);?></td>
								<td <?php echo "$bg";?>><?php echo strtoupper($row->task_act_duration);?></td>
							</tr>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="10"> <?php echo $this->pagination->create_links();?> </td>
							</tr>
						</tfoot>						
                    </table>
        			<?php } ?>
        
 			</div>
            <!-- wigget content -->
            
            </div>
            <!-- widget -->          
          
          </div>
          <!-- col -->
          
        </div>
        <!-- row -->

</div>
<?php include($this->config->item('footer')); ?>