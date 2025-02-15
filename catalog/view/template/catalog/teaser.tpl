<div id="catalog-section">
  <div class="catalog-teaser-container">
    <?php foreach ($catalog_categories as $category) { ?>
    <div class="catalog-teaser-item" href="<?php echo $category['href']; ?>">
      <div class="catalog-teaser-item-image">
        <a href="<?php echo $category['href']; ?>">
          <img src="data:<?php echo $category['image_type']; ?>;base64,<?php echo $category['image_data']; ?>"
            title="<?php echo $category['image_title']; ?>" />
        </a>

      </div>
      <div class="catalog-teaser-item-info">
        <div class="catalog-teaser-item-headline">
          <?php echo $category['name']; ?>
        </div>
        <div class="catalog-teaser-item-subcategories">
          <?php foreach ($category['subcategories'] as $subcategory) { ?>
          <a href="<?php echo $subcategory['href']; ?>">
            <?php echo $subcategory['name']; ?>
          </a>
          <?php } ?>
        </div>

      </div>
    </div>
    <?php } ?>
  </div>
</div>