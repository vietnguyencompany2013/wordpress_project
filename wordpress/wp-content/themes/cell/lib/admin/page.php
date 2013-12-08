<div class="wrap">
  
  <?php 
  /** Get the parent theme data. */
  $cell_theme_data = cell_theme_data();
  screen_icon();
  ?>
  <h2><?php echo sprintf( __( '%1$s Theme Settings', 'cell' ), $cell_theme_data['Name'] ); ?></h2>    
  
  <?php settings_errors( 'cell_options' ); ?>
  
  <form action="options.php" method="post">
    
    <?php settings_fields('cell_options_group'); ?>
    
    <div id="cell_tabs" class="cell-tabs">
    
      <ul>
        <li><a href="#cell_section_blog_tab"><?php _e( 'Blog Options', 'cell' ); ?></a></li>
        <li><a href="#cell_section_general_tab"><?php _e( 'General Options', 'cell' ); ?></a></li>        
      </ul>
      
      <div id="cell_section_blog_tab"><?php do_settings_sections( 'cell_section_blog_page' ); ?></div>
      <div id="cell_section_general_tab"><?php do_settings_sections( 'cell_section_general_page' ); ?></div>      
    
    </div>
    
    <p class="submit">
      <input name="Submit" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'cell' ); ?>" />
    </p>
  
  </form>

</div>