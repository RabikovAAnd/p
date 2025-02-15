<?php
class ControllerNewsTeaser extends Controller 
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  protected function index() 
  {

    // Load messages
    $this->messages->Load( $this->data, 'news', 'teaser', 'index', $this->language->Get_Language_Code() );

    // Load news model
    $this->load->model( 'news/news' );

    //--------------------------------------------------------------------------

    // Set headline link
    $this->data[ 'news_teaser_header_href' ] = $this->url->link( 'news/list', '' );

    //--------------------------------------------------------------------------
    // Process last news
    //--------------------------------------------------------------------------

    // Query SQL database for latest news
    $latest_news = $this->model_news_news->Get_Teaser_Latest_News( $this->language->Get_Language_Code() );
    
    // Process news content
    $this->data[ 'news_teaser_latest_news_headline' ] = $latest_news[ 'headline' ];
    $this->data[ 'news_teaser_latest_news_body' ] = $latest_news[ 'body' ];
    $this->data[ 'news_teaser_latest_news_date' ] = date( 'd.m.Y', strtotime( substr( $latest_news[ 'creation_date' ], 0, 10 ) ) );
    $this->data[ 'news_teaser_latest_news_href' ] = $this->url->link( 'news/info', 'news_id=' . $latest_news[ 'id' ] );

    // Process news image
    if ( isset( $latest_news[ 'image_data' ] ) )
    {
      $this->data[ 'news_teaser_latest_news_image' ] = 'data:'. $latest_news[ 'image_type' ] . ';base64, ' . base64_encode( $latest_news[ 'image_data' ] );
    }
    else
    {
      $this->data[ 'news_teaser_latest_news_image' ] = '';
    }
    
    //--------------------------------------------------------------------------
    // Process last news
    //--------------------------------------------------------------------------

    // Create array
    $this->data[ 'news_news_teaser' ] = array();

    // Query SQL database
    $lines = $this->model_news_news->Get_Teaser_News( 10, $this->language->Get_Language_Code() );

    // Iterate over all news items
    foreach ( $lines as $line )
    {
      
      // Add news items to array
      $this->data[ 'news_teaser' ][] = array (
        'href' => $this->url->link( 'news/info', 'news_id=' . $line[ 'id' ] ),
        'headline' => $line[ 'headline' ],
        'date' => date( 'd.m.Y', strtotime( substr( $line[ 'creation_date' ], 0, 10 ) ) )
      );

    }

    //--------------------------------------------------------------------------
    // Render page
    //--------------------------------------------------------------------------

    // Add CSS file to document
    $this->response->addStyle( 'catalog/view/stylesheet/news/teaser.css' );

    // Render page
    $this->Render( 'news/teaser.tpl' );

  }

}
//------------------------------------------------------------------------------
// End of class
//------------------------------------------------------------------------------
?>