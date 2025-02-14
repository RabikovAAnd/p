<?php echo $common_header; ?>
<div id="content-section">

    <h1 class="heading"><?php echo $company_about_header; ?></h1>
<div class="list">
      <?php foreach ( $sections as $section ) {?>
    <div class="info-content-block list">
      <h2><?php echo $section[ 'headline' ]; ?></h2>
      <div class="info-content-text ">
      <?php foreach ( $section[ 'paragraphs' ] as $paragraph ) {?>
        <div class="info-text"><?php echo $paragraph[ 'text' ]; ?></div>
      <?php } ?>
      </div>
    </div>
    <?php } ?>

</div>


</div>
<?php echo $common_footer; ?>
