<?php echo $common_header; ?>
<div>
    <h1><?php echo $country_country_header; ?></h1>
    <div class="info-content-block">
        <div class="">
            <div class="countries-list">
                <?php $first_letter = null; ?>
                <?php foreach ($countries as $country) {
                    if( $first_letter!==strtoupper(substr($country['country_name'], 0, 1))){
                    $first_letter=strtoupper(substr($country['country_name'], 0, 1));
                ?></div>

            <div class="countries-first-letter"><?php echo $first_letter?> </div>

            <div class="countries-list">
                <?php } ?>
                <?php if ($country['country_active']){ ?>
                <a class="button country active-button" href="<?php echo $country['country_link']; ?>">
                    <img
                            src = "<?php echo $country['country_path']; ?>"
                            title="<?php echo $country['country_iso']; ?>"/>
                    <?php echo $country['country_name']; ?>
                </a>
                <?php } else{ ?>
                <a  class="button inactive-button country" href="<?php echo $country['country_link']; ?>">
                    <img
                            src = "<?php echo $country['country_path']; ?>"
                            title="<?php echo $country['country_iso']; ?>"/>
                    <?php echo $country['country_name']; ?>
                </a>

                <?php }} ?>
            </div>

        </div>
    </div>

</div>
<?php echo $common_footer; ?>

