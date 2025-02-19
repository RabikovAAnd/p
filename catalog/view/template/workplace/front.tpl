<?php echo $common_header; ?>

<div id="content">
  <h1>
    <?php echo $workplace_front_header; ?>
  </h1>

  <div class="account-area">
    <?php echo $workplace_menu; ?>
    <div>
      <div class="list">
        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_front_contacts_header; ?>
          </h2>
          <?php if ( isset( $contacts ) && count( $contacts )>0) { ?>
          <div class="table-menu-style">
            <div class="contacts-table table-menu-header">
              <span><b>
                  <?php echo $workplace_front_contacts_table_name; ?>
                </b></span>
            </div>
            <?php foreach ( $contacts as $contact ){ ?>

            <div id="<?php echo $contact[ 'element_href' ]; ?>" class="contacts-table table-menu-element">

              <span><a href="<?php echo $contact[ 'href' ]; ?>">

                  <?php echo $contact[ 'name' ]; ?>
                </a></span>

              <div class="table-button-menu" style="display: none;">
                <button class="red-button" onMouseDown="File_Form('<?php echo $contact[ 'remove_href' ]; ?>')">
                  <?php echo $workplace_front_delete_contact_button_text; ?>
                </button>

              </div>
            </div>


            <?php }?>
          </div>
          <?php }else{?>
          <div>
            <?php echo $workplace_front_contacts_not_found; ?>
          </div>
          <?php }?>
        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_front_projects_header; ?>
          </h2>
          <?php if ( isset( $projects )  && count( $projects )>0) { ?>
          <div class="table-menu-style">

            <div class="projects-table table-menu-header">
              <span><b>
                  <?php echo $workplace_front_projects_table_designator; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_projects_table_name; ?>
                </b></span>
            </div>
            <?php foreach ( $projects as $project ){ ?>

            <div id="<?php echo $project[ 'element_href' ]; ?>" class="projects-table table-menu-element">

              <span><a href="<?php echo $project[ 'href' ]; ?>">
                  <?php echo $project[ 'designator' ]; ?>
                </a></span>
              <span>
                <?php echo $project[ 'name' ]; ?>
              </span>

              <div class="table-button-menu" style="display: none;">
                <button class="red-button"
                  onMouseDown="File_Form('<?php echo $delete_customer_project_button_href; ?>',[['guid','<?php echo $project[ 'guid' ]; ?>'],['remove',true]])">
                  <?php echo $workplace_front_delete_project_button_text; ?>
                </button>

              </div>
            </div>
            <?php }?>
          </div>
          <?php }else{?>
          <div>
            <?php echo $workplace_front_projects_not_found; ?>
          </div>
          <?php }?>
        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_front_items_header; ?>
          </h2>
          <?php if ( isset( $observed_items )  && count( $observed_items )>0) { ?>
          <div class="table-menu-style">
            <div class="items-table table-menu-header">
              <span><b>
                  <?php echo $workplace_front_items_table_id; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_items_table_mpn; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_items_table_manufacturer; ?>
                </b></span>
            </div>
            <?php foreach ( $observed_items as $observed_item ){ ?>
            <div id="<?php echo $observed_item[ 'element_href' ]; ?>" class="items-table table-menu-element">
              <span>
                <?php echo $observed_item[ 'item_id' ]; ?>
              </span>
              <span><a href="<?php echo $observed_item[ 'item_href' ]; ?>">
                  <?php echo $observed_item[ 'mpn' ]; ?>
                </a></span>
              <span>
                <?php echo $observed_item[ 'manufacturer_name' ]; ?>
              </span>

              <div class="table-button-menu" style="display: none;">
                <button class="red-button"
                  onMouseDown="File_Form('<?php echo $delete_customer_item_button_href; ?>',[['item_guid','<?php echo $observed_item[ 'item_guid' ]; ?>'],['remove',true]])">
                  <?php echo $workplace_front_delete_item_button_text; ?>
                </button>
              </div>

            </div>
            <?php }?>
          </div>
          <?php }else{?>
          <div>
            <?php echo $workplace_front_items_not_found; ?>
          </div>
          <?php }?>

        </div>

        <div class="info-content-block list">
          <h2>
            <?php echo $workplace_front_task_table_header; ?>
          </h2>

          <?php if ( count( $tasks_groups ) > 0 ) { ?>
          <?php foreach ( $tasks_groups as $tasks_group ) { ?>
          <?php if(count($tasks_group['data'])>0){?>
          <h3>
            <?php /* echo $workplace_front_items_header; */ ?>
            <?php  echo $tasks_group['name']; ?>
          </h3>

          <div class="table-menu-style">

            <div class="task-table-c1 table-menu-header">
              <span><b>
                  <?php echo $workplace_front_task_table_header_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_task_table_priority_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_task_table_dates_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_task_table_dates_text; ?>
                </b></span>
              <span><b>
                  <?php echo $workplace_front_task_table_lead_time_text; ?>
                </b></span>
            </div>

            <?php foreach ( $tasks_group['data'] as $task ) { ?>

            <div class="task-table-c1 table-menu-element">
              <span>
                <?php echo $task[ 'item_guid' ]; ?><br>
                <?php echo $task[ 'header' ]; ?>
              </span>
              <span>
                <?php echo $task[ 'priority' ]; ?>
              </span>
              <span>
                <?php echo $task[ 'date_start' ]; ?>
              </span>
              <span>
                <?php echo $task[ 'deadline' ]; ?>
              </span>
              <span>
                <?php echo $task[ 'lead_time' ]; ?>
              </span>

              <div class="table-button-menu" style="display: none;">

                <?php if ( $task[ 'delete_button_enabled' ] == 1 ) { ?>
                <button type="button" id="<?php echo $task[ 'id' ]; ?>"
                  onMouseDown="File_Form('<?php echo $delete_task_button_href; ?>',[['task_id',event.target.id]])">
                  <?php echo $workplace_front_delete_task_button_text; ?>
                </button>
                <?php } ?>

                <?php if ( $task[ 'delete_button_enabled' ] == 1 ) { ?>
                <button type="button" id="<?php echo $task[ 'id' ]; ?>"
                  onMouseDown="File_Form('<?php echo $delete_task_button_href; ?>',[['task_id',event.target.id]])">
                  <?php echo $workplace_front_delete_task_button_text; ?>
                </button>

                <?php } ?>

                <?php if ( $task[ 'edit_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'edit_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_edit_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'confirm_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $confirm_task_href; ?>">
                  <button type="button">
                    <?php echo $workplace_front_confirm_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'discard_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $discard_task_href; ?>">
                  <button type="button">
                    <?php echo $workplace_front_discard_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'assign_developer_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'assign_developer_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_assign_developer_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'start_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'start_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_start_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'reject_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'reject_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_reject_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'done_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'done_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_done_task_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'pause_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'pause_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_pause_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'resume_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'resume_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_resume_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'assign_verifier_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'assign_verifier_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_assign_verifier_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'verify_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'verify_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_verify_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'accept_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'accept_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_accept_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'reopen_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'reopen_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_reopen_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'decline_button_enabled' ] == 1 ) { ?>
                <a href="<?php echo $task[ 'decline_task_href' ]; ?>">
                  <button type="button">
                    <?php echo $workplace_front_decline_button_text; ?>
                  </button>
                </a>
                <?php } ?>

                <?php if ( $task[ 'observe_button_enabled' ] == 1 ) { ?>
                <button class="inactive-button">
                  <?php echo $workplace_front_observe_task_button_text; ?>
                </button>
                <?php } ?>

                <?php if ( $task[ 'delegate_button_enabled' ] == 1 ) { ?>
                <button class="inactive-button">
                  <?php echo $workplace_front_delegate_task_button_text; ?>
                </button>
                <?php } ?>

                <?php if ( $task[ 'move_button_enabled' ] == 1 ) { ?>
                <button class="inactive-button">
                  <?php echo $workplace_front_move_task_button_text; ?>
                </button>
                <?php } ?>

                <?php if ( $task[ 'close_button_enabled' ] == 1 ) { ?>
                <button class="inactive-button">
                  <?php echo $workplace_front_close_task_button_text; ?>
                </button>
                <?php } ?>

              </div>

            </div>

            <?php } ?>
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $common_footer; ?>

<script>

  $(document).ready(function () {

    let tasks_buttons = $('.buttons').toArray()
    tasks_buttons.forEach((element) => {
      if ($(element).children().length == 0) {
        $(element).hide();
      }
    });
  })

</script>