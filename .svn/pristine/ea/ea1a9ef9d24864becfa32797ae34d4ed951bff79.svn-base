<?php echo $common_header; ?>
<div>
  <h1><?php echo $manufacturers_list_header; ?></h1>
  <div class="info-content-block">
  <div class="manufacturers-list">
    <?php if ($manufacturers) { ?>
    <?php $first_letter = null; ?>
    <?php foreach ($manufacturers as $manufacturer) {
      if( $first_letter!==strtoupper(substr($manufacturer['name'], 0, 1))) {
      $first_letter=strtoupper(substr($manufacturer['name'], 0, 1)); ?>
  </div>

  <div class="first-letter"><?php echo $first_letter; ?> </div>

  <div class="manufacturers-list">
    <?php } ?>
    <a href="<?php echo $manufacturer[ 'manufacturer_href' ]; ?>" class="button inactive-button manufacturer"><?php echo $manufacturer['name']; ?></a>
    <?php } ?>
  </div>

<?php } ?>
  </div>
</div>
<?php echo $common_footer; ?>
