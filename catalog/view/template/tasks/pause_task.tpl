<?php echo $common_header; ?>

<div id="content">
  <h1> <?php echo $tasks_pause_task_header; ?></h1>

<div class="account-area">
  <?php echo $workplace_menu; ?>
  <div class="list info-content-block">
    <?php echo $task[ 'header' ]; ?>
    <br>
    <br>
    <?php echo $task[ 'description' ]; ?>
      <label>
        <?php echo $tasks_pause_task_message_label; ?>
        <input id="message"
               type="text"
               title="<?php echo $tasks_pause_task_message_hint;  ?>"
               placeholder="<?php echo $tasks_pause_task_message_placeholder; ?>">
      </label>
      
      <div>
        <div class="buttons">

          <a  href="<?php echo $tasks_pause_task_cancel_button_href; ?>"
              
             title="<?php echo $tasks_pause_task_cancel_button_hint; ?>">
             <button type="button" class="inactive-button">
              <?php echo $tasks_pause_task_cancel_button_text; ?>
             </button>
            
          </a>
          <button type="button" id="send-message-button"
                  class="save-changes"
                  title="<?php echo $tasks_pause_task_save_button_hint; ?>"
                  onMouseDown="Pause()">
            <?php echo $tasks_pause_task_save_button_text; ?>
          </button>
  
        </div>
        <span class="error-alert"></span>
      
      </div>
   
  </div>
</div>

</div>
<?php echo $common_footer; ?>
 <script>
  function Pause(){
    Send_Data("<?php echo $task_data; ?>"+"&message="+$('#message').val(),"<?php echo $tasks_pause_task_button_href; ?>")
  }
 </script>