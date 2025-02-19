<div id="column-news">

  <div class="news-teaser-container ">
    <a class="list" href="<?php echo $news_teaser_latest_news_href; ?>">

      <div class="news-teaser-main-news">
        <?php if ($news_teaser_latest_news_image !== ''){ ?>
        <img src="<?php echo $news_teaser_latest_news_image; ?>">
        <?php } else{?>
        <img class="main-item-image" src="./image/default/no_image.jpg" />
        <?php } ?>
        <div class="list">
          <h2>
            <?php echo $news_teaser_latest_news_headline; ?>
          </h2>
          <?php echo $news_teaser_latest_news_body; ?>
          <span class="news-date">
            <?php echo $news_teaser_latest_news_date; ?>
          </span>
        </div>

      </div>

    </a>
    <div class="news-teaser-item">

      <?php foreach ($news_teaser as $item) { ?>
      <a class="news-list-item" href="<?php echo $item['href']; ?>">
        <h2 class="news-list-item__headline">
          <?php echo $item[ 'headline' ]; ?>
        </h2>
        <span class="news-date">
          <?php echo $item['date']; ?>
        </span>
      </a>

      <?php } ?>
    </div>
  </div>
</div>