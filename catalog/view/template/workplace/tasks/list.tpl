<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $workplace_tasks_header; ?></h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
  
    <div class="list">
      <?php foreach ( $tasks_groups as $tasks_group ){ ?>
      <div class="info-content-block list">
        <h2><?php /*echo $workplace_tasks_task_table_header; */?><?php echo $tasks_group['name']; ?></h2>
        <div class="table-menu-style">
           <div class="task-table-c1 table-menu-header">
          <span><b><?php echo $workplace_tasks_task_table_header_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_priority_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_dates_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_dates_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_lead_time_text; ?></b></span>
          </div>
          <?php foreach (  $tasks_group['data'] as $task ){ ?>
            <div class="task-table-c1 table-menu-element">
              <span><?php echo $task[ 'item_guid' ]; ?><br><?php echo $task[ 'header' ]; ?></span>
              <span><?php echo $task[ 'priority' ]; ?></span>
              <span><?php echo $task[ 'date_start' ]; ?></span>
              <span><?php echo $task[ 'deadline' ]; ?></span>
              <span><?php echo $task[ 'lead_time' ]; ?></span>
              <div id="<?php echo $task[ 'id' ]; ?>" class="table-button-menu" style="display: none;">
    
                <?php if ( $task[ 'delete_button_enabled' ] == 1 ) { ?>           
                  <button href="<?php echo $task[ 'delete_task_href' ]; ?>"><?php echo $workplace_tasks_delete_task_button_text; ?></button>
                <?php } ?>
                
                <?php if ( $task[ 'edit_button_enabled' ] == 1 ) { ?>            
                <a href="<?php echo $task[ 'edit_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_edit_task_button_text; ?></button>
                </a>
                <?php } ?>
      
                <?php if ( $task[ 'confirm_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'confirm_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_confirm_task_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'discard_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'discard_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_discard_task_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'assign_developer_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'assign_developer_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_assign_developer_task_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'start_button_enabled' ] == 1 ) { ?>            
                  <a href="<?php echo $task[ 'start_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_start_task_button_text; ?></button>
                  </a>
                  <?php } ?>
               
                <?php if ( $task[ 'reject_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'reject_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_reject_task_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'done_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'done_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_done_task_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'pause_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'pause_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_pause_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'resume_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'resume_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_resume_button_text; ?></button>
                  </a>
                <?php } ?>
                
                <?php if ( $task[ 'assign_verifier_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'assign_verifier_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_assign_verifier_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'verify_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'verify_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_verify_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'accept_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'accept_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_accept_button_text; ?></button>
                  </a>
                <?php } ?>
      
                <?php if ( $task[ 'reopen_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'reopen_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_reopen_button_text; ?></button>
                  </a>
                <?php } ?>
                
                <?php if ( $task[ 'decline_button_enabled' ] == 1 ) { ?>
                  <a href="<?php echo $task[ 'decline_task_href' ]; ?>">
                    <button type="button"><?php echo $workplace_tasks_decline_button_text; ?></button>
                  </a>
                <?php } ?>
                
                <?php if ( $task[ 'observe_button_enabled' ] == 1 ) { ?>
                  <button type="button" class="inactive-button"><?php echo $workplace_tasks_observe_task_button_text; ?></button>
                <?php } ?>
                
                <?php if ( $task[ 'delegate_button_enabled' ] == 1 ) { ?>
                  <button type="button" class="inactive-button"><?php echo $workplace_tasks_delegate_task_button_text; ?></button>
                <?php } ?>
                
                <?php if ( $task[ 'move_button_enabled' ] == 1 ) { ?>
                  <button type="button" class="inactive-button"><?php echo $workplace_tasks_move_task_button_text; ?></button>
                <?php } ?>
                
                <?php if ( $task[ 'close_button_enabled' ] == 1 ) { ?>
                  <button type="button" class="inactive-button"><?php echo $workplace_tasks_close_task_button_text; ?></button>
                <?php } ?>
    
              </div>
            </div>
          <?php } ?>    
        </div>  

      </div>  
      <?php } ?> 
      <!-- <div class="info-content-block list">
        <h2><?php /*echo $workplace_tasks_task_table_header; */?>Tasks created by me</h2>  

        <div class="task-table-c1 table-style">
          <span><b><?php echo $workplace_tasks_task_table_header_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_priority_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_dates_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_dates_text; ?></b></span>
          <span><b><?php echo $workplace_tasks_task_table_lead_time_text; ?></b></span>
          <?php foreach ( $created_tasks as $created_task ){ ?>
            <span><?php echo $created_task[ 'item_guid' ]; ?><br><?php echo $created_task[ 'header' ]; ?></span>
            <span><?php echo $created_task[ 'priority' ]; ?></span>
            <span><?php echo $created_task[ 'date_start' ]; ?></span>
            <span><?php echo $created_task[ 'deadline' ]; ?></span>
            <span><?php echo $created_task[ 'lead_time' ]; ?></span>
            <div id="<?php echo $created_task[ 'id' ]; ?>" class="buttons">
  
              <?php if ( $created_task[ 'delete_button_enabled' ] == 1 ) { ?>           
                <button onMouseDown="Delete_Task()"><?php echo $workplace_tasks_delete_task_button_text; ?></button>
              <?php } ?>
              
              <?php if ( $created_task[ 'edit_button_enabled' ] == 1 ) { ?>            
              <a href="<?php echo $created_task[ 'edit_task_href' ]; ?>">
                <button type="button"><?php echo $workplace_tasks_edit_task_button_text; ?></button>
              </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'confirm_button_enabled' ] == 1 ) { ?>
                
                  <button type="button" onMouseDown="Confirm_Task("<?php echo $created_task[ 'id' ]; ?>")"><?php echo $workplace_tasks_confirm_task_button_text; ?></button>
                
              <?php } ?>
    
              <?php if ( $created_task[ 'discard_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'discard_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_discard_task_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'assign_developer_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'assign_developer_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_assign_developer_task_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'start_button_enabled' ] == 1 ) { ?>            
                <a href="<?php echo $created_task[ 'start_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_start_task_button_text; ?></button>
                </a>
                <?php } ?>
             
              <?php if ( $created_task[ 'reject_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'reject_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_reject_task_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'done_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'done_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_done_task_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'pause_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'pause_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_pause_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'resume_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'resume_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_resume_button_text; ?></button>
                </a>
              <?php } ?>
              
              <?php if ( $created_task[ 'assign_verifier_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'assign_verifier_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_assign_verifier_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'verify_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'verify_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_verify_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'accept_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'accept_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_accept_button_text; ?></button>
                </a>
              <?php } ?>
    
              <?php if ( $created_task[ 'reopen_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'reopen_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_reopen_button_text; ?></button>
                </a>
              <?php } ?>
              
              <?php if ( $created_task[ 'decline_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $created_task[ 'decline_task_href' ]; ?>">
                  <button type="button"><?php echo $workplace_tasks_decline_button_text; ?></button>
                </a>
              <?php } ?>
              
              <?php if ( $created_task[ 'observe_button_enabled' ] == 1 ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_tasks_observe_task_button_text; ?></button>
              <?php } ?>
              
              <?php if ( $created_task[ 'delegate_button_enabled' ] == 1 ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_tasks_delegate_task_button_text; ?></button>
              <?php } ?>
              
              <?php if ( $created_task[ 'move_button_enabled' ] == 1 ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_tasks_move_task_button_text; ?></button>
              <?php } ?>
              
              <?php if ( $created_task[ 'close_button_enabled' ] == 1 ) { ?>
                <button type="button" class="inactive-button"><?php echo $workplace_tasks_close_task_button_text; ?></button>
              <?php } ?>
  
            </div>
          <?php } ?>    
          
        </div>  

      </div>   -->

      
    </div>
  </div> 
</div>
<?php echo $common_footer; ?>
  
