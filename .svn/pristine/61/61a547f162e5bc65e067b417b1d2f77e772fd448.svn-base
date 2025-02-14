<?php echo $common_header; ?>
<div id="content-section">

  <h1><?php echo $text_parent_category_header; ?></h1>


    <div class="categories-container list">

        <?php foreach ( $categories as $category ) { ?>
        <?php if ( $category['image_type'] == '' ) { ?>

        <a  class="info-content-block" href="<?php echo $category['href']; ?>">
            <h2><?php echo $category['name']; ?></h2>
            <div class="info-text"><?php echo $category[ 'description' ]; ?></div>
        </a>

        <?php } else { ?>

            <a class="catalog-item-info info-content-block" href="<?php echo $category['href']; ?>">
                <img
                        src="data:<?php echo $category['image_type']; ?>;base64,<?php echo $category['image_data']; ?>"
                        title="<?php echo $category['name']; ?>"/>

                    <div class="description">
                        <h2><?php echo $category['name']; ?></h2>
                        <div><?php echo $category[ 'description' ]; ?></div>
                    </div>
                    <div class="features">

                        <h3>Свойства</h3>
                        <ul>
                            <?php foreach ( $category[ 'properties' ] as $property ) { ?>
                            <li><?php echo $property[ 'name' ] . " : " . $property[ 'value' ] ?></li>
                            <?php } ?>
                        </ul>
                    </div>


            </a>



        <?php } ?>
        <?php } ?>

    </div>

</div>
<?php echo $common_footer; ?>
