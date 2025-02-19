<?php echo $common_header; ?>

<div id="content">
  <h1> <?php echo $tasks_edit_task_header; ?></h1>

<div class="account-area">
  <?php echo $workplace_menu; ?>
  <div class="list info-content-block">
    <input id="task_id" class="input-send" value="<?php echo $task[ 'id' ]; ?>" style="display: none;">
      <label>
        <?php echo $tasks_edit_task_task_info_header; ?>
        <input id="header"
               type="text"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_header_hint;  ?>"
               placeholder="<?php echo $tasks_edit_task_task_info_header_placeholder; ?>"
               value="<?php echo $task[ 'header' ]; ?>">
      </label>
      <label>
        <?php echo $tasks_edit_task_task_info_description; ?>
        <input id="description"
               type="text"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_description_hint;  ?>"
               placeholder="<?php echo $tasks_edit_task_task_info_description_placeholder; ?>"
               value="<?php echo $task[ 'description' ]; ?>">
      </label>
      <label>
        <?php echo $tasks_edit_task_task_info_priority; ?>
        <select id="priority"
                class="input-send"
                title="<?php echo  $tasks_edit_task_task_info_priority_hint;  ?>">
          <?php foreach ($priorities as $priority) { ?>
            <?php if($priority['sort_order'] === $task['priority']) { ?>
          <option value="<?php echo $priority['sort_order']; ?>" selected><?php echo $priority['name']; ?></option>
          <?php }else{ ?>
            <option value="<?php echo $priority['sort_order']; ?>"><?php echo $priority['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>
      </label>
      <label>
        <?php echo $tasks_edit_task_task_info_date_start; ?>
        <?php if($task[ 'date_start' ] === "0000-00-00 00:00:00" ) { ?>
        <input id="date_start"
               type="datetime-local"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_date_start_hint;  ?>">
        <?php }else{ ?>
          <input id="date_start"
               type="datetime-local"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_date_start_hint;  ?>"
               value="<?php echo $task[ 'date_start' ]; ?>">
          <?php } ?>
      </label>
      <label>
        <?php echo $tasks_edit_task_task_info_deadline; ?>
        <?php if($task[ 'deadline' ] === "0000-00-00 00:00:00" ) { ?>
          <input id="deadline"
               type="datetime-local"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_deadline_hint;  ?>">
          <?php }else{ ?>
        <input id="deadline"
               type="datetime-local"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_deadline_hint;  ?>"
               value="<?php echo $task[ 'deadline' ]; ?>">
               <?php } ?>
      </label>
      <label>
        <?php echo $tasks_edit_task_task_info_lead_time; ?>
        <input id="lead_time"
              type="number"
               class="input-send"
               title="<?php echo $tasks_edit_task_task_info_lead_time_hint;  ?>"
               placeholder="<?php echo $tasks_edit_task_task_info_lead_time_placeholder; ?>"
               value="<?php echo $task[ 'lead_time' ]; ?>">
      </label>
      <label>
        <?php echo $tasks_edit_task_task_info_executor; ?>
            <select id="customer_guid"
                    class="input-send select2"
                    title="<?php echo  $cart_show_customer_data_country_hint;  ?>">
              <option value="0"><?php echo $cart_show_country_placeholder; ?></option>
              <?php foreach ($customers as $customer) { ?>
              <?php if ($customer['guid'] == $task[ 'customer_guid' ]) { ?>
              <option value="<?php echo $customer['guid']; ?>"
                      selected="selected"><?php echo $customer['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $customer['guid']; ?>"><?php echo $customer['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
      </label>
      <div>
        <div class="buttons">

          <a  href="<?php echo $tasks_edit_task_cancel_button_href; ?>"
             title="<?php echo $account_address_form_cancel_button_hint; ?>">
             <button type="button" class="inactive-button">
              <?php echo $tasks_edit_task_cancel_button_text; ?>
             </button>
            
          </a>
          <button type="button" id="send-message-button"
                  class="save-changes"
                  title="<?php echo $account_address_form_save_button_hint; ?>"
                  onMouseDown="File_Form('<?php echo $tasks_edit_task_save_button_href; ?>')">
            <?php echo $tasks_edit_task_save_button_text; ?>
          </button>
  
        </div>
        <span class="error-alert"></span>
      
      </div>
   
  </div>
</div>

</div>
<?php echo $common_footer; ?>
  <script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "Выберите город",
      maximumSelectionLength: 2,
      language: "ru"
    });
  });   
  </script>
