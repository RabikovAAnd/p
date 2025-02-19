<?php
class ControllerWorkplaceItemsExportEbay extends Controller
{

  //----------------------------------------------------------------------------
  // Index method
  //----------------------------------------------------------------------------

  public function index()
  {

    // Load messages
    $this->messages->Load( $this->data, 'workplace', 'items_export_ebay', 'index', $this->language->Get_Language_Code() );

    // Load data models
    $this->load->model( 'items/items' );
    $this->load->model( 'items/properties' );
    $this->load->model( 'items/images' );
//    $this->load->model( 'items/subitems/subitems' );
//    $this->load->model( 'items/subitems/alternatives' );
//    $this->load->model( 'properties/properties' );

    // Test for item GUID parameter exists
    if ( $this->request->Is_GET_Parameter_GUID( 'guid' ) === false )
    {

      //----------------------------------------------------------------------
      // ERROR: Item GUID parameter not found
      //----------------------------------------------------------------------

      //! @todo ANVILEX KM: Redirect to item not found page

    }
    else
    {

      //------------------------------------------------------------------------
      // Item GUID parameter found, continue processing
      //------------------------------------------------------------------------

      // Get item guid
      $item_guid = $this->request->Get_GET_Parameter_As_GUID( 'guid' );

      // Get item information
      $item = $this->model_items_items->Get_Information( $item_guid );

      // Test for item information valid      
      if ( $item[ 'return_code' ] === false )
      {

        //----------------------------------------------------------------------
        // ERROR: Item information invalid
        //----------------------------------------------------------------------

        // Redirect to item error page

      }
      else
      {

        //----------------------------------------------------------------------
        // ERROR: Item information valid
        //----------------------------------------------------------------------

        // Get item images
        $item_images = $this->model_items_images->Get_Item_Images( $item_guid );

        // Get item grupped properties
        $item_properties_groups = $this->model_items_items->Get_Properties_2( $item_guid, $this->language->Get_Language_Code() );

      }
      


      //--------------------------------------------------------------------
      // Define styles
      //--------------------------------------------------------------------
  
      $style_container =
        'width: 100%;' .
        'margin: 0px;' .
        'padding: 0px;' .
        'border: none;' .
        'font-family: Arial ,Verdana, Geneva, Helvetica, sans-serif;';
  
      $style_top_banner =
        'background: #0000FF;' .
        'color: #FFFFFF;' .
        'height: 56px;' .
        'font-family: Arial;' .
        'font-size: 48px;' .
        'font-weight: bold;' .
        'padding-left: 10px;' .
        'padding-right: 10px;' .
        'padding-top: 5px;' .
        'padding-bottom: 5px;' .
        'text-align: right;';
  
      $style_headline =
        'background: #0000FF;' .
        'padding-left: 10px;' .
        'padding-right: 10px;' .
        'padding-top: 10px;' .
        'padding-bottom: 10px;';
  
      $style_h1 =
        'color: #FFFFFF;' .
        'font-size: 24px;' .
        'font-weight: normal;' .
        'text-align: left;' .
        'letter-spacing: 0.03em;';
  
      $style_content = 
        'width: 100%;' .
        'margin: 0;' .
        'padding: 0;' .
        'border: none;' .
        'background: #FFFFFF;';
  
      $style_content_table = 
        'table-layout: fixed;' .
        'width: 100%;' .
        'border: 0px;' .
        'border-spacing: 0px;';
  
      $style_content_table_column_1 =
        'width: 33%;' .
        'vertical-align: top;' .
        'padding-top: 10px;' .
        'padding-bottom: 0px;';
  
      $style_content_table_column_2 =
        'width: 10px;';
  
      $style_content_table_column_3 =
        'width: *;' .
        'vertical-align: top;' .
        'padding-top: 10px;' .
        'padding-bottom: 0px;';
  
      $stype_image_table =
        'table-layout: fixed;' .
        'width: 100%;' .
        'border: 0px;' .
        'border-spacing: 0px;';
  
      $style_content_table_column_1_image =
        'padding-left: 0px;' .
        'padding-right: 0px;' .
        'padding-top: 0px;' .
        'padding-bottom: 10px;';
  
      $style_content_table_column_1_image_img =
        'width: 100%;';
  
      $style_content_table_column_3_table =
        'border: 0px;' .
        'border-spacing: 0px;';
  
      $style_content_table_column_3_caption =
        'color: #0000FF;' .
        'font-size: 22px;' .
        'font-weight: normal;' .
        'padding-left: 10px;' .
        'padding-right: 10px;' .
        'padding-top: 20px;' .
        'padding-bottom: 0px;' .
        'text-align: right;' .
        'letter-spacing: 0.03em;';
  
      $style_content_table_column_3_application =
        'color: #0000FF;' .
        'background: #FF7F00;' .
        'color: #FFFFFF;' .
        'font-size: 16px;' .
        'padding-left: 10px;' .
        'padding-right: 10px;' .
        'padding-top: 10px;' .
        'padding-bottom: 10px;' .
        'text-align: left;' .
        'line-height: 150%;' .
        'letter-spacing: 0.03em;' .
        'width: 100%;';
  
      $style_content_table_column_3_body =
        'padding-left: 10px;' .
        'padding-right: 10px;' .
        'padding-top: 10px;' .
        'padding-bottom: 10px;';
  
      $style_content_table_column_3_body_p =
        'color: #000000;' .
        'font-size: 14px;' .
        'font-weight: normal;' .
        'text-align: left;' .
        'letter-spacing: 0.03em;' .
        'padding-bottom: 5px;';
  
      $style_properties_caption =
        'color: #000000;' .
        'font-size: 18px;' .
        'text-align: left;' .
        'vertical-align: top;' .
        'letter-spacing: 0.04em;' .
        'padding-left: 10px;' .
        'padding-top: 15px;' .
        'padding-bottom: 0px;';
  
      $style_properties_text =
        'color: #000000;' .
        'font-size: 14px;' .
        'text-align: left;' .
        'vertical-align: top;' .
        'letter-spacing: 0.04em;' .
        'padding-left: 10px;' .
        'padding-top: 5px;' .
        'padding-bottom: 0px;';
  
      $style_properties_value =
        'color: #000000;' .
        'font-size: 14px;' .
        'text-align: right;' .
        'vertical-align: top;' .
        'letter-spacing: 0.04em;' .
        'padding-right: 10px;' .
        'padding-top: 5px;' .
        'padding-bottom: 0px;';
  
      $style_bottom_banner =
        'background: #0000FF;' .
        'color: #FFFFFF;' .
        'font-size: 14px;' .
        'padding-left: 10px;' .
        'padding-right: 10px;' .
        'padding-top: 10px;' .
        'padding-bottom: 10px;' .
        'text-align: left;' .
        'letter-spacing: 0.03em;';

      //--------------------------------------------------------------------
      // Data
      //--------------------------------------------------------------------
  
      $headline = 'Headline';

      //--------------------------------------------------------------------
      // HTML
      //--------------------------------------------------------------------
      
      $content = '<!DOCTYPE html>' . PHP_EOL;
      $content .= '<html><head><meta http-equiv="Content-Type" content="text/html;charset=UTF-8"></head><body>' . PHP_EOL;
      $content .= '<div id="container" style="' . $style_container . '">' . PHP_EOL;
      $content .= ' <div id="top_banner" style="' . $style_top_banner . '">ANVILEX</div>' . PHP_EOL;
      $content .= ' <div id="headline" style="' . $style_headline . '">' . PHP_EOL;
      $content .= '  <h1 style="' . $style_h1 . '">' . $headline . '</h1>' . PHP_EOL;
      $content .= ' </div>' . PHP_EOL;
  
      $content .= ' <div id="content" style="' . $style_content . '">' . PHP_EOL;
      $content .= '  <table id="content_table" cellspacing="0" cellpadding="0" style="' . $style_content_table . '">' . PHP_EOL;
      $content .= '   <tbody>' . PHP_EOL;
      $content .= '    <tr>' . PHP_EOL;
      $content .= '     <td id="content_table_column_1" style="' . $style_content_table_column_1 . '">' . PHP_EOL;
      $content .= '      <table id="image_table" cellspacing="0" cellpadding="0" style="' . $stype_image_table . '">' . PHP_EOL;
      $content .= '       <tbody>' . PHP_EOL;
  
      // Initialise item picture index
//      $item_picture_index = 1;

      foreach ( $item_images as $item_image )
      {

//        if ( $item_image[ 'type' ] == '' )

        // Compose item image file name
        $item_image_server_file_name = DIR_IMAGE . 'ebay/' . $item_image[ 'guid' ] . '.jpg';
        $item_image_web_file_name = 'https://www.anvilex.com/ebay/' . $item_image[ 'guid' ] . '.jpg';
       
        //-------------------------
/*
        // Create main image object
        $main_image = new Image();
        $main_image->Create_From_String( $images[ 0 ][ 'data' ] );

        // Resize main image
        $main_image->resize( 300, 300, 'w' );

        // Get main image information
        $main_image_info = $main_image->Get_Info();

        // Set main image data
        $this->data[ 'item' ][ 'main_image' ] = array(

          'image_type' => $main_image_info[ 'mime' ],
          'image_data' => $main_image->Get_Encoded()
        );
*/
        //-----------------------------
        
        // Test for item image exported to disk
        
        // Save the image data to a file
        file_put_contents( $item_image_server_file_name, $item_image[ 'data' ] );

        $content .= '        <tr>' . PHP_EOL;
        $content .= '         <td>' . PHP_EOL;
        $content .= '          <div class="content_table_column_1_image" style="' . $style_content_table_column_1_image . '">' . PHP_EOL;
        $content .= '           <img style="' . $style_content_table_column_1_image_img . '" src="' . $item_image_web_file_name . '" alt="' . $item[ 'mpn' ]. '">' . PHP_EOL;
        $content .= '          </div>' . PHP_EOL;
        $content .= '         </td>' . PHP_EOL;
        $content .= '        </tr>' . PHP_EOL;

        // Increment item image index
//        $item_picture_index++;
  
      }
  
      $content .= '       </tbody>' . PHP_EOL;
      $content .= '      </table>' . PHP_EOL;
      $content .= '     </td>' . PHP_EOL;

      $content .= '     <td id="content_table_column_2" style="' . $style_content_table_column_2 . '">' . PHP_EOL;
      $content .= '     </td>' . PHP_EOL;
  
      $content .= '     <td id="content_table_column_3" style="' . $style_content_table_column_3 . '">' . PHP_EOL;  
      $content .= '      <table cellspacing="0" cellpadding="0" style="' . $style_content_table_column_3_table . '">' . PHP_EOL;
      $content .= '       <tbody>' . PHP_EOL;
  
      $content .= '        <tr>' . PHP_EOL;
      $content .= '         <td colspan="2">' . PHP_EOL;
      $content .= '          <div class="content_table_column_3_application" style="' . $style_content_table_column_3_application . '">' . PHP_EOL;
      $content .= '           Zweiseitige Ausf�hrung mit L�tstoppmaske<br>' . PHP_EOL;
      $content .= '           Kontakte mit Goldbeschiechtung<br>' . PHP_EOL;
      $content .= '           Kontakte f�r zus�tzlichen Komponenten an der R�ckseite<br>' . PHP_EOL;
      $content .= '           Geeignet f�r DIY Projekte<br>' . PHP_EOL;
      $content .= '           Geeignet f�r Prototyping von elektrischer Schaltungen' . PHP_EOL;
      $content .= '          </div>' . PHP_EOL;
      $content .= '         </td>' . PHP_EOL;
      $content .= '        </tr>' . PHP_EOL;
  
      $content .= '        <tr>' . PHP_EOL;
      $content .= '         <td colspan="2">' . PHP_EOL;
      $content .= '          <div class="content_table_column_3_caption" style="' . $style_content_table_column_3_caption . '">' . PHP_EOL;
      $content .= '           Beschreibung' . PHP_EOL;
      $content .= '          </div>' . PHP_EOL;
      $content .= '         </td>' . PHP_EOL;
      $content .= '        </tr>' . PHP_EOL;

/*  
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td colspan=""2"">" )
      o_Output_File.WriteLine( "                  <div class=""content_table_column_3_body"" style=""" + style_content_table_column_3_body + """>" )
      o_Output_File.WriteLine( "                    <p>Mit dieser zweiseitigen Adapterplatine k�nnen Sie ICs im Geh�use " + string_Package + " �ber die Stiftleisten auf eine Lochraster- oder Steckboard-Platine im �blichen 2,54 mm-Raster (0,1"") adaptieren.</p>" )
      o_Output_File.WriteLine( "                    <p>Auf r�ckseite der Adapterplatine befinden sich Kontakte f�r die Montage von zus�tzlichen Komponenten.</p>" )
      o_Output_File.WriteLine( "                    <p>Weitere Adapterplatine und Leiterplatten finden Sie ebenfalls in unserem eBay Shop.</p>" )
      o_Output_File.WriteLine( "                  </div>" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
*/    

      $content .= '        <tr>' . PHP_EOL;
      $content .= '         <td colspan="2">' . PHP_EOL;
      $content .= '          <div class="content_table_column_3_caption" style="' . $style_content_table_column_3_caption . '">' . PHP_EOL;
      $content .= '           Technische Daten' . PHP_EOL;
      $content .= '          </div>' . PHP_EOL;
      $content .= '         </td>' . PHP_EOL;
      $content .= '        </tr>' . PHP_EOL;


      foreach ( $item_properties_groups[ 'data' ] as $item_properties_group )
      {

        $content .= '        <tr>' . PHP_EOL;
        $content .= '         <td colspan="2" class="properties_caption" style="' . $style_properties_caption . '">' . $item_properties_group[ 'name' ] . '</td>' . PHP_EOL;
        $content .= '        </tr>' . PHP_EOL;

        foreach ( $item_properties_group[ 'properties' ] as $property )
        {

          $content .= '        <tr>' . PHP_EOL;
          $content .= '         <td class="properties_text" style="' . $style_properties_text . '">' . $property[ 'name' ] . '</td>' . PHP_EOL;
          $content .= '         <td class="properties_value" style="' . $style_properties_value . '">' . $property[ 'value' ] . ( ( $property[ 'unit' ] == '' ) ? '' : ' ' . $property[ 'unit' ] ) . '</td>" )' . PHP_EOL;
          $content .= '        </tr>' . PHP_EOL;

        }
      
      }

/*
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Hersteller" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  ANVILEX" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Herstellernummer" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( string_Project )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  IC Geh�usetyp" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( string_Package )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Anzahl von Geh�usekontakte" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( string_Package_Pin )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Geh�usekontakte Rasterma�" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( string_Package_Pitch )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Pinabstand der L�taugen" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  2,54mm" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Durchmesser der L�taugen" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  1,00mm" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Kontaktbeschichtung" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  Gold" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Artikel ID" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  ID" + string_ID )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_caption"" style=""" + style_properties_caption + """>"  )
      o_Output_File.WriteLine( "                  Mechanische Eigenschaften" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Material" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  FR-4, Epoxyd Glasfaser" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Farbe" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  Gr�n" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Dicke" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  1,6mm" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Abmessungen" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( "                  " + string_Board_Width + " x " + string_Board_Height )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
    
      o_Output_File.WriteLine( "              <tr>" )
      o_Output_File.WriteLine( "                <td class=""properties_text"" style=""" + style_properties_text + """>"  )
      o_Output_File.WriteLine( "                  Gewicht" )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "                <td class=""properties_value"" style=""" + style_properties_value + """>"  )
      o_Output_File.WriteLine( string_Board_Weight )
      o_Output_File.WriteLine( "                </td>" )
      o_Output_File.WriteLine( "              </tr>" )
*/

      $content .= '        <tr>' . PHP_EOL;
      $content .= '         <td colspan="2">' . PHP_EOL;
      $content .= '          <div class="content_table_column_3_caption" style="' . $style_content_table_column_3_caption . '">' . PHP_EOL;
      $content .= '           Wichtig' . PHP_EOL;
      $content .= '          </div>' . PHP_EOL;
      $content .= '         </td>' . PHP_EOL;
      $content .= '        </tr>' . PHP_EOL;
    
      $content .= '        <tr>' . PHP_EOL;
      $content .= '         <td colspan="2">' . PHP_EOL;
      $content .= '          <div class="content_table_column_3_body" style="' . $style_content_table_column_3_body . '">' . PHP_EOL;
      $content .= '           <p>Sollte diese Adapterplatine nicht zu Ihre IC passen, ben�tigen sie eine spezielle Ausf�hrung oder Anpassung, w�rden wir sie bitten, sich mit uns in Verbindung zu setzen.</p>' . PHP_EOL;
      $content .= '          </div>' . PHP_EOL;
      $content .= '         </td>' . PHP_EOL;
      $content .= '        </tr>' . PHP_EOL;
  
      $content .= '       </tbody>' . PHP_EOL;
      $content .= '      </table>' . PHP_EOL;
  
      $content .= '     </td>' . PHP_EOL;
      $content .= '    </tr>' . PHP_EOL;
      $content .= '   </tbody>' . PHP_EOL;
  
      $content .= '  </table>' . PHP_EOL;
  
      $content .= ' </div>' . PHP_EOL;
  
      $content .= ' <div id="bottom_banner" style="' . $style_bottom_banner . '">' . PHP_EOL;
      $content .= utf8_encode( '  <b>Wichtig, vor dem Kauf zu beachten:</b><br>' ) . PHP_EOL;
      $content .= '  <br>' . PHP_EOL;
      $content .= utf8_encode( '  1. Bitte bezahlen Sie erst, wenn Sie alle ben�tigten Artikel ersteigert oder per Sofortkauf erworbenen haben. Nur dadurch k�nnen alle Artikel zu einem Auftrag zusammengefasst werden und es fallen nur einmal Versandkosten an.<br>' ) . PHP_EOL;
      $content .= '  <br>' . PHP_EOL;
      $content .= utf8_encode( '  2. Sie zahlen nur einmal Versandkosten egal wie viele Artikel Sie kaufen, wenn Sie Punkt 1 beachten. De H�he der Versandkosten richtet sich nach dem Artikel mit dem h�chsten Versandkostenbetrag. Sollten die Versandkosten in der Kaufabwicklung von eBay nicht richtig berechnet sein, fordern Sie bette �ber eBay den Gesamtbetrag an, damit wir dies korrigieren k�nnen.<br>' ) . PHP_EOL;
      $content .= '  <br>' . PHP_EOL;
      $content .= utf8_encode( '  3. Alle Auftr�ge, die bis 9:00 Uhr (Montag bis Freitag) bezahlt wurden, werden von uns noch am gleichen Tag versendet. Bei Briefversand ben�tigt die Deutsche Post in der Regel 1..2 Werktage f�r den Versand. Bei Sparversand per Warensendung ben�tigt die Deutsche Post eine Laufzelt von 2..6 Tagen. Unter Umst�nden kann die Laufzelt In Spitzenzeiten bis zu 10 Werktage betragen. Sollte Ihre Sendung nach 2 Wochen noch nicht bei Ihnen eingetroffen sein, w�rden wir sie bitten, sich mit uns in Verbindung zu setzen.<br>' ) . PHP_EOL;
      $content .= ' </div>' . PHP_EOL;
      $content .= '</div>' . PHP_EOL;
      $content .= '</body></html>' . PHP_EOL;

      $item_html_server_file_name = DIR_IMAGE . 'ebay/' . $item_guid . '.html';

      // Save the item data to a file
      file_put_contents( $item_html_server_file_name, $content );

      //--------------------------------------------------------------------
      // Render page
      //--------------------------------------------------------------------

      // Set document properties
      $this->response->setTitle( '' );
      $this->response->setDescription( '' );
      $this->response->setRobots( 'index, follow' );
  
      // Set page configuration
      $this->children = array(
        'common/footer',
        'workplace/menu',
        'common/header'
      );
      
    }
  
  }

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>