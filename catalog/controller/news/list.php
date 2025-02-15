<?php
class ControllerNewsList extends Controller 
{

  //----------------------------------------------------------------------------
  // Default method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'news', 'list', 'index', $this->language->Get_Language_Code() );

    // Load news model
    $this->load->model( 'news/news' );

    // Create array
    $this->data[ 'years' ] = array();
    $this->data[ 'news' ] = array();

    // Get years
    $years = $this->model_news_news->Get_News_Years();

    // Test for validity
    if ( $years[ 'valid' ] == false )
    {

      //------------------------------------------------------------------------
      // No news years found
      //------------------------------------------------------------------------

      // Clear show news flag
      $this->data[ 'show_news' ] = false;

    }
    else
    {

      //------------------------------------------------------------------------
      // News years found
      //------------------------------------------------------------------------

      // Try to get parameter
      if ( isset( $this->request->get[ 'year' ] ) == false ) 
      {

        //----------------------------------------------------------------------
        // ERROR: Parameter not set
        //----------------------------------------------------------------------

        // Select last available year
        $selected_year = array_values( $years[ 'years' ] )[ 0 ];

      }
      else
      {

        //----------------------------------------------------------------------
        // Parameter found
        //----------------------------------------------------------------------

        // Get selected year
        $selected_year = (int)$this->request->get[ 'year' ];

      }

      // Test for parameter in valid range
      if ( in_array( $selected_year, $years ) == false )
      {

        //--------------------------------------------------------------------
        // ERROR: Year not found in the years list
        //--------------------------------------------------------------------

        // Clear show news flag
        $this->data[ 'show_news' ] = false;

      }
      else
      {

        //--------------------------------------------------------------------
        // Requested year not found in the years list
        //--------------------------------------------------------------------
          
        // Set show news flag
        $this->data[ 'show_news' ] = true;

        // Get news for selected year
        $news = $this->model_news_news->Get_News_Id_By_Year( $selected_year );

        // Test validity
        if ( $news[ 'valid' ] == false )
        {

          //------------------------------------------------------------------
          // ERROR: No news found
          //------------------------------------------------------------------

        }
        else
        {

          // Iterate over all news items
          foreach ( $news[ 'data' ] as $news_id )
          {

            // Get news information
            $news_info = $this->model_news_news->Get_News_Item( $news_id, $this->language->Get_Language_Code() );

//          $this->data[ 'text_message_header_1' ] = implode( $news_info, ' : ' );

            // Check news info validity
            if ( $news_info[ 'valid' ] == true )
            {

                // Get image
//                $image = $this->model_news_news->getNews_Item_Image( $result['id'] );

              // Add news items to array
              $this->data['news'][] = array (
                'date' => date( 'd.m.Y', strtotime( $news_info['creation_date'] ) ),
                'headline' => $news_info[ 'headline' ],
                'agenda' => $news_info[ 'agenda' ],
                'href' => $this->url->link( 'news/info', 'news_id=' . $news_info[ 'id' ] )
              );

            }
//            else
//            {
                
//              $this->data['news'][] = $news_id . ' : ' . implode($news_info) . ' : ' . implode( $news[ 'data' ] ) . $news[ 'sql' ];
              
//            }

          }
  
        }

      }

      // Iterate over all years
      foreach ( $years[ 'years' ] as $year )
      {

        // Set news years
        $this->data[ 'years' ][] = array
        (
          'year' => $year,
          'selected' => ( ( $year == $selected_year ) ? true : false ),
          'href' => $this->url->link( 'news/list', 'year=' . $year )
        );

      }

    }

    // Set page data
//    $this->data[ 'text_message_header' ] = sprintf( $this->language->get( 'company_news_heading_text' ), $selected_year );
//    $this->data[ 'text_message_header' ] = sprintf( $this->language->get( 'headline' ), $selected_year );

    //------------------------------------------------------------------------
    // Render page
    //------------------------------------------------------------------------

    // Set document properties
    $this->response->setTitle( $this->messages->Get_Message( 'document_title_text' ) );
    $this->response->setDescription( $this->messages->Get_Message( 'document_description_text' ) );
    $this->response->setKeywords( '' );
    $this->response->setRobots( 'index, follow' );

    // Add CSS file to document
    $this->response->addStyle( 'catalog/view/stylesheet/news/list.css' );

    // Set page configuration
    $this->children = array(
      'common/footer',
      'common/header'
    );

  }

}
//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>