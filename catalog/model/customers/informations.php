<?php
class ModelCustomersInformations extends Model 
{

  //----------------------------------------------------------------------------
  // Get customer information
  //----------------------------------------------------------------------------

	public function Get_Information( $name, $language_code )
	{

    // Create output data
    $sections_data = array();

		// Compose SQL query
		$sql = 
      "SELECT " .
        "`customer_informations`.`id` AS id, " .
        "`customer_informations_sections`.`section_id` AS section_id, " .
        "`customer_informations_sections`.`headline` AS headline " .
      "FROM " .
        "`customer_informations` " . 
      "LEFT JOIN " .
        "`customer_informations_sections` " .
      "ON " .
        "`customer_informations_sections`.`information_id`=`customer_informations`.`id` " .
      "WHERE " .
        "`customer_informations`.`name`='" . $this->db->escape( $name ) . "' AND " .
        "`customer_informations_sections`.`language_code`='" . $this->db->escape( $language_code ) . "'";

		// Query database
		$sections = $this->db->query( $sql );

    // Process all sections 
    foreach ( $sections->rows as $section )
    {

      // Compose SQL query
      $sql = 
      "SELECT " .
        "`customer_informations_sections`.`section_id` AS id, " .
        "`customer_informations_texts`.`text` AS text " .
      "FROM " .
        "`customer_informations_sections` " . 
      "LEFT JOIN " .
        "`customer_informations_texts` " .
      "ON " .
        "`customer_informations_texts`.`section_id`=`customer_informations_sections`.`section_id` AND " .
        "`customer_informations_texts`.`language_code`=`customer_informations_sections`.`language_code` " .
      "WHERE " .
        "`customer_informations_sections`.`section_id`=" . $section[ 'section_id' ] . " AND " .
        "`customer_informations_texts`.`language_code`='" . $this->db->escape( $language_code ) . "'";

      // Query database
      $paragraphs = $this->db->query( $sql );

      // Initialise phasagraphs array 
      $paragraph_data = array();
      
      // Process all sections 
      foreach ( $paragraphs->rows as $paragraph )
      {
        
        // Compose paragraph data
        $paragraph_data[] = array(
          'text' => $paragraph[ 'text' ]
        );

      }
      
      // Compose section data
      $sections_data[] = array(
       'headline' => $section[ 'headline' ],
       'paragraphs' => $paragraph_data
      );
 
    }

		// Return data
		return( $sections_data );

	}

}

//------------------------------------------------------------------------------
// End of file
//------------------------------------------------------------------------------
?>
