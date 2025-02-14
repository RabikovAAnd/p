<?php echo $common_header; ?>
<div>
  <h1><?php echo $language_language_header; ?></h1>
  <div class="info-content-block languages-list">

    <?php foreach ($languages as $language) { ?>
    <?php if  ($language['language_active']){ ?>

      <a class="button active-button" href="<?php echo $language['language_link']; ?>">
        <?php echo $language['language_name']; ?>
      </a>

    <?php } else{ ?>

      <a class="button inactive-button" href="<?php echo $language['language_link']; ?>">
        <?php echo $language['language_name']; ?>
      </a>

    <?php }} ?>
  </div>
</div>
<?php echo $common_footer; ?>