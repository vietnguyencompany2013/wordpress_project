<div class="wrap farad-settings">
  
  <?php 
  /** Get the parent theme data. */
  $farad_theme_data = farad_theme_data();
  screen_icon();
  ?>
  
  <h2><?php echo sprintf( __( '%1$s Theme Settings', 'farad' ), $farad_theme_data['Name'] ); ?></h2>    
  
  <?php settings_errors(); ?>
  
  <div id="farad-pro-wrapper">
    <a href="http://designorbital.com/farad-pro/" class="button button-primary button-hero" target="_blank"><?php _e( 'Farad Pro Features', 'farad' ); ?></a>
  </div>
  
  <form action="options.php" method="post" id="farad-form-wrapper">
    
    <div id="farad-form-header" class="farad-clearfix">
      <input type="submit" name="" id="" class="button button-primary" value="<?php _e( 'Save Changes', 'farad' ); ?>">
    </div>
	
	<?php settings_fields('farad_options_group'); ?>
    
    <div id="farad-sidebar">
      
      <ul id="farad-group-menu">
        <li id="0_section_group_li" class="farad-group-tab-link-li active"><a href="javascript:void(0);" id="0_section_group_li_a" class="farad-group-tab-link-a" data-rel="0"><span><?php _e( 'Blog Settings', 'farad' ); ?></span></a></li>
        <li id="1_section_group_li" class="farad-group-tab-link-li"><a href="javascript:void(0);" id="1_section_group_li_a" class="farad-group-tab-link-a" data-rel="1"><span><?php _e( 'Post Settings', 'farad' ); ?></span></a></li>
        <li id="2_section_group_li" class="farad-group-tab-link-li"><a href="javascript:void(0);" id="2_section_group_li_a" class="farad-group-tab-link-a" data-rel="2"><span><?php _e( 'Footer Settings', 'farad' ); ?></span></a></li>
        <li id="3_section_group_li" class="farad-group-tab-link-li"><a href="javascript:void(0);" id="3_section_group_li_a" class="farad-group-tab-link-a" data-rel="3"><span><?php _e( 'General Settings', 'farad' ); ?></span></a></li>
      </ul>
    
    </div>
    
    <div id="farad-main">
    
      <div id="0_section_group" class="farad-group-tab">
        <?php do_settings_sections( 'farad_section_blog_page' ); ?>
      </div>
      
      <div id="1_section_group" class="farad-group-tab">
        <?php do_settings_sections( 'farad_section_post_page' ); ?>
      </div>
      
      <div id="2_section_group" class="farad-group-tab">
        <?php do_settings_sections( 'farad_section_footer_page' ); ?>
      </div>
      
      <div id="3_section_group" class="farad-group-tab">
        <?php do_settings_sections( 'farad_section_general_page' ); ?>
      </div>
    
    </div>
    
    <div class="clear"></div>
    
    <div id="farad-form-footer" class="farad-clearfix">
      <input type="submit" name="" id="" class="button button-primary" value="<?php _e( 'Save Changes', 'farad' ); ?>">
    </div>
    
  </form>

</div>