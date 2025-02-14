<?php echo $common_header; ?>
<div>

  <div class="generic-page-header-grid">
    <div class="generic-page-header-empty-cell"></div>
    <div class="generic-page-header-title-cell">
      <h1 class="generic-page-header-title-text"><?php echo $heading_title; ?></h1>
    </div>
  </div>

  <div class="generic-page-content-grid">

    <div class="project-add-grid">

      <div class="project-add-cell">
        <div class="project-add-query-grid" >
          <div class="project-add-query-cell">
            <input class="project-add-query-input" type="text" id="project-number-input" name="project-number-input" placeholder="<?php echo $project_add_number_placeholder_text; ?>" value="<?php echo $project_add_number_placeholder_value; ?>" />
            <input class="project-add-query-input" type="text" id="project-name-input" name="project-name-input" placeholder="<?php echo $project_add_name_placeholder_text; ?>" value="" />
            <textarea class="project-add-emails-input" type="text" id="project-description-input" name="project-description-input" rows="4" placeholder="<?php echo $project_add_description_placeholder_text; ?>"></textarea>
          </div>
          <div class="project-add-query-cell">
            <a class="project-add-query-button" id="project-add-button"><?php echo $project_add_button_caption; ?></a>
          </div>
        </div>
      </div>

      <div class="project-add-results-cell" id="project-add-results">
      </div>

    </div>

  </div>

</div>

<script type="text/javascript"><!--

//------------------------------------------------------------------------------
// Add project button
//------------------------------------------------------------------------------

$( 'a#project-add-button' ).bind( 'click', function() {

  // Get query strings
//  var project_number = $( 'input#project-number-input' ).attr( 'value' );
//  var project_name = $( 'input#project-name-input' ).attr( 'value' );
  var project_number = $( 'input#project-number-input' ).val();
  var project_name = $( 'input#project-name-input' ).val();
  var project_description = $( 'textarea#project-description-input' ).val();

  $.ajax({
    url: 'index.php?route=projects/add/add',
    type: 'post',
    data: 'number=' + project_number + '&name=' + project_name + '&description=' + project_description,
    dataType: 'json',
    success: function( json ) {

      switch ( json[ 'return_code' ] )
      {

        case 'success':
        {

          var html = '<div class="project-add-results-grid" >';
          html += '<div class="project-add-results-cell">';
          html += json[ 'number' ] + ' : ' + json[ 'name' ];
          html += '</div>';
          html += '<div class="project-add-results-cell">';
          html += '<?php echo $project_add_result_added_text; ?>';
          html += '</div>';
          html += '</div>';

          $( 'div#project-add-results' ).prepend( html );

          $( 'input#project-number-input' ).val('');
          $( 'input#project-name-input' ).val('');
          $( 'textarea#project-description-input' ).val('');

          break;

        }

        case 'error':
        {

          var html = '<div class="project-add-results-grid" >';
          html += '<div class="project-add-results-cell">';
          html += json[ 'number' ] + ' : ' + json[ 'name' ];
          html += '</div>';
          html += '<div class="project-add-results-cell">';
          html += '<?php echo $project_add_result_error_text; ?>';
          html += '</div>';
          html += '</div>';

          $( 'div#project-add-results' ).prepend( html );

          break;

        }

        case 'exists':
        {

          var html = '<div class="project-add-results-grid" >';
          html += '<div class="project-add-results-cell">';
          html += json[ 'number' ] + ' : ' + json[ 'name' ];
          html += '</div>';
          html += '<div class="project-add-results-cell">';
          html += '<?php echo $project_add_result_exists_text; ?>';
          html += '</div>';
          html += '</div>';

          $( 'div#project-add-results' ).prepend( html );

          $( 'input#project-number-input' ).val('');
          $( 'input#project-name-input' ).val('');
          $( 'textarea#project-description-input' ).val('');

          break;

        }

        default:
        {

          var html = '<div class="project-add-results-grid" >';
          html += '<div class="project-add-results-cell">';
          html += json[ 'number' ] + ' : ' + json[ 'name' ];
          html += '</div>';
          html += '<div class="project-add-results-cell">';
          html += '<?php echo $project_add_result_unknown_text; ?>';
          html += '</div>';
          html += '</div>';

          $( 'div#project-add-results' ).prepend( html );

          break;

        }

      }

    }

  });

});

//------------------------------------------------------------------------------

//--></script>

<?php echo $common_footer; ?>
