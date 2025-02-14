<?php echo $common_header; ?>
<div id="content-section">
    <h1><?php echo $news_list_header; ?></h1>

    <div class="news-content-grid">
        <div class="news-years-cell">
            <?php foreach ( $years as $year ) { ?>
                <?php if ( $year[ 'selected' ] == true ) { ?>
                    <a class="news-year-index-button-selected" href="<?php echo $year['href']; ?>">
                        <?php echo $year[ 'year' ]; ?>
                    </a>
                    <?php } else { ?>
                    <a class="news-year-index-button" href="<?php echo $year['href']; ?>">
                        <?php echo $year[ 'year' ]; ?>
                    </a>
                <?php } ?>
            <?php } ?>
        </div>

        <div class="news-content-cell">
            <?php foreach ( $news as $news_item ) { ?>

            <a class="news-content-cell-item list" href="<?php echo $news_item['href']; ?>">
                <h2 class="news-list-message-headline"><?php echo $news_item[ 'headline' ]; ?></h2>
                <div class="news-list-message-text"><?php echo $news_item[ 'agenda' ]; ?></div>
                <span class="date"><?php echo $news_item[ 'date' ] ?></span>
            </a>

            <?php } ?>
        </div>

    </div>

</div>
<?php echo $common_footer; ?>
