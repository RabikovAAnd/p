<?php echo $common_header; ?>

<div id="content">
  <h1><?php echo $tasks_add_task_header; ?> </h1>

<div class="account-area">
  <?php echo $workplace_menu; ?>
  <div>
    <div class="list info-content-block">
      <div class="project">
        <div class="project-info">
        <input id="item_guid" value="<?php echo $item_guid; ?>" class="input-send" style="display:none">
          <label>
            <?php echo $tasks_add_task_task_info_header; ?>
            <input id="header" class="input-send" type="text">
          </label>
          <label>
            <?php echo $tasks_add_task_task_info_description; ?>
            <textarea id="description" rows="4" class="input-send"></textarea>
          </label>
          <label>
            <?php echo $tasks_add_task_task_info_priority; ?>
            <select id="priority"
                    class="input-send"
                    title="<?php echo  $cart_show_customer_data_country_hint;  ?>">
              <?php foreach ($priorities as $priority) { ?>
                <?php if($priority['sort_order'] === $task_priority_no_category) { ?>
              <option value="<?php echo $priority['sort_order']; ?>" selected><?php echo $priority['name']; ?></option>
              <?php }else{ ?>
                <option value="<?php echo $priority['sort_order']; ?>"><?php echo $priority['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </label>
          <label>
            <?php echo $tasks_add_task_task_info_date_start; ?>
            <input id="date_start" class="input-send" type="datetime-local">
          </label>
          <label>
            <?php echo $tasks_add_task_task_info_deadline; ?>
            <input id="deadline" class="input-send" type="datetime-local">
          </label>
          <label>
            <?php echo $tasks_add_task_task_info_lead_time; ?>
            <input id="lead_time" class="input-send" type="text">
          </label>
<?php /*
          <label>
            <?php echo $tasks_add_task_task_info_executor; ?>
            <input type="text" id="customer_full_name" class="input-send"  list="customer_list"/>
            <datalist id="customer_list" >
              <?php foreach ($customers as $customer) { ?>
              <option name="<?php echo $customer['guid']; ?>"><?php echo $customer['lastname']; ?> <?php echo $customer['name']; ?></option>
              <?php } ?>
            </datalist>
          </label>
*/ ?>
        </div>


      </div>

      <div class="send">
        <button type="button" id="add-task"
        onMouseDown="File_Form('<?php echo $projects_add_task_button_href; ?>')">
        <?php echo $tasks_add_task_add_task_button_text; ?>
        </button>
        <span class="error-alert"></span>
      </div>


    </div>
  </div>

</div>

</div>
<?php echo $common_footer; ?>

<script>
/*
  $('#customer_full_name').keyup(function () {
    Search();
  });

  function Search() {
    $.ajax({
      url: 'index.php?route=tasks/add_task/Search',
      type: 'POST',
      dataType: 'json',
      data: 'search=' + $('#customer_full_name').val(),
      success: function (json) {
        $('#customer_list').html('')

        if (json['return_code']) {

          if (json['customers']) {

            json['customers'].forEach((customer) => {
              $('#customer_list').append('<option id="'+customer['guid']+'">'+customer['lastname'] + ' ' + customer['name'] + '</option>');
          })
        }
      }
    },
      error: function (jqXHR, exception, json) {
        console.log('error ' + exception + ' ' + json['error']);
      }

    });
  }
*/
</script>