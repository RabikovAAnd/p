<?php echo $common_header; ?>
<div>

  <div class="generic-page-header-grid">
    <div class="generic-page-header-empty-cell"></div>
    <div class="generic-page-header-title-cell">
      <h1 class="generic-page-header-title-text"><?php echo $heading_title; ?></h1>
    </div>
  </div>

  <div class="generic-page-content-grid">

    <div class="project-activity-list-grid">
    <?php foreach ( $projects as $project ) { ?>

      <div class="project-activity-list-cell">

        <div class="project-activity-list-item-grid">

          <div class="project-activity-list-item-date-cell">
            <div class="project-activity-list-item-date-text"><?php echo $project[ 'activity_date' ]; ?></div>
          </div>

          <div class="project-activity-list-item-project-cell">
            <div class="project-activity-list-item-project-text"><?php echo $project[ 'project_number' ]; ?></div>
          </div>

          <div class="project-activity-list-item-description-cell">
            <div class="project-activity-list-item-name-text"><?php echo $project[ 'project_name' ]; ?></div>
            <div class="project-activity-list-item-activity-text"><?php echo $project[ 'activity_name' ]; ?></div>
          </div>

          <div class="project-activity-list-item-duration-cell">
            <div class="project-activity-list-item-duration-text"><?php echo $project[ 'activity_duration' ]; ?></div>
          </div>

        </div>

      </div>

    <?php } ?>
    </div>

  </div>

</div>

<?php echo $common_footer; ?>
