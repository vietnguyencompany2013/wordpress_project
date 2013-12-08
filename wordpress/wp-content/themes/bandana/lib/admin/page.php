<div class="wrap bandana-settings">
  
  <?php 
  /** Get the parent theme data. */
  $bandana_theme_data = bandana_theme_data();
  screen_icon();
  ?>
  
  <h2><?php echo sprintf( __( '%1$s Theme Settings', 'bandana' ), $bandana_theme_data['Name'] ); ?></h2>    
  
  <?php settings_errors( 'bandana_options' ); ?>
  
  <form action="options.php" method="post">
    
    <?php settings_fields('bandana_options_group'); ?>
    
    <div id="bandana_tabs">
    
      <ul>
        <li><a href="#bandana_section_blog_tab"><?php _e( 'Blog Options', 'bandana' ); ?></a></li>
        <li><a href="#bandana_section_general_tab"><?php _e( 'General Options', 'bandana' ); ?></a></li>        
      </ul>
      
      <div id="bandana_section_blog_tab"><?php do_settings_sections( 'bandana_section_blog_page' ); ?></div>
      <div id="bandana_section_general_tab"><?php do_settings_sections( 'bandana_section_general_page' ); ?></div>      
    
    </div>
    
    <p class="submit">
      <input name="Submit" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'bandana' ); ?>" />
    </p>
  
  </form>

</div>