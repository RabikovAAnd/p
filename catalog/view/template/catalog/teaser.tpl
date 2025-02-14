<div id="catalog-section">
    <a href="<?php echo $catalog_teaser_header_href; ?>">
        <h1><?php echo $catalog_teaser_header; ?></h1>
    </a>
    <div class="catalog-teaser-container">
        <?php foreach ($catalog_categories as $category) { ?>
        <a class="catalog-teaser-item" href="<?php echo $category['href']; ?>">
            <div class="catalog-teaser-item-image"><img
                        src="data:<?php echo $category['image_type']; ?>;base64,<?php echo $category['image_data']; ?>"
                        title="<?php echo $category['image_title']; ?>"/></div>
            <div class="catalog-teaser-item-headline"><?php echo $category['name']; ?></div>
        </a>
        <?php } ?>
    </div>
</div>