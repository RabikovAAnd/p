
<div class="company-teaser">
    <div class="company-teaser-item list">
        <h2><?php echo $company_teaser_about_company_header; ?></h2>
        <div class="company-teaser-company-about">
            <img class="company-teaser-company-img" src="./image/default/no_image.jpg" title="<?php echo $company_teaser_image_hint; ?>">
            <div class="company-teaser-item-text"><?php echo $company_teaser_about_text; ?></div>
        </div>
    </div>
    <div class="company-teaser-item list">
        <h2><?php echo $company_teaser_projects_header;  ?></h2>
        <div>
            <?php if ( $company_teaser_projects_list[ 'return_code' ] == true ) { ?>
            <?php foreach ( $company_teaser_projects_list[ 'data' ] as $company_teaser_project ) { ?>
            <div class="company-teaser-item-text"><?php echo $company_teaser_project[ 'name' ]; ?></div>        
            <?php } ?>
        <?php } ?>
        </div>
    </div>
</div>