<?php echo $common_header; ?>

<div id="content">
  <h1 class="header-list__password">
    <?php echo  $account_password_password_header; ?>
  </h1>

  <div class="info-content-block">
    <div>
      <div class="content">
        <label>
          <span>*
            <?php echo $account_password_password_data_new_password_label; ?>
          </span>
          <input type="password" id="password" name="password" class="input-send"
            title="<?php echo $account_password_password_data_new_password_hint; ?>" min="8" max="20" required />
        </label>
        <label>
          <span>*
            <?php echo $account_password_password_data_confirm_password_label; ?>
          </span>
          <input type="password" id="confirm" name="confirm" class="input-send"
            title="<?php echo $account_password_password_data_confirm_password_hint; ?>" min="8" max="20" required />
        </label>
      </div>
    </div>
    <div class="end">
      <button type="button" onMouseDown="File_Form('<?php echo $save_changes_button_href; ?>')"
        title="<?php echo $account_password_save_changes_buttom_hint; ?>">
        <?php echo $account_password_save_changes_buttom_caption; ?>
      </button>

    </div>
    <span class="error-alert"></span>
  </div>
</div>

<?php echo $common_footer; ?>