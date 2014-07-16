<script type="text/javascript">
    if (window.WMPJSInterface && window.WMPJSInterface != null){
        jQuery(document).ready(function(){
            
            WMPJSInterface.localpath = "<?php echo plugins_url()."/".WMP_DOMAIN."/"; ?>";
            WMPJSInterface.init();
        });
    }
</script>
<div id="wmpack-admin">
    <div class="spacer-20"></div>
    <!-- set title -->
    <h1><?php echo WMP_PLUGIN_NAME;?></h1>
    <div class="spacer-20"></div>

    <?php $page_content = WMobilePackAdmin::wmp_more_updates();?>
    <div class="more">
        <div class="left-side"> 
        
            <!-- add nav menu -->
            <?php include_once('sections/wmp-admin-menu.php'); ?>
            <div class="spacer-0"></div>
    
    		<?php if(is_array($page_content) && !empty($page_content)):?>
				<?php if (array_key_exists('tablets', $page_content)):?>
        
                    <div class="details">
                        <div class="spacer-10"></div>
                        <?php if (array_key_exists('title', $page_content['tablets'])):?>
                            <h1><?php echo $page_content['tablets']['title'];?></h1>
                        <?php endif;?>
                        
                        <div class="spacer-20"></div>
                        <?php if (array_key_exists('banner', $page_content['tablets'])):?>
                            <div class="showcase">
                                <img src="<?php echo $page_content['tablets']['banner'];?>" />
                            </div>
                            <div class="spacer-20"></div>
                        <?php endif;?>
                        
                        <?php if (array_key_exists('subtitle', $page_content['tablets'])):?>
                            <p class="subtitle"><?php echo $page_content['tablets']['subtitle'];?></p>
                            <div class="spacer-20"></div>
                        <?php endif;?>
                        
                        <?php if (array_key_exists('button_text', $page_content['tablets']) && array_key_exists('button_link', $page_content['tablets'])):?>
                        
                            <div class="try-it">
                            	<?php
									$feed_url = '';
                                    
                                    if (get_bloginfo('atom_url') != null && get_bloginfo('atom_url') != '')
                                        $feed_url = '&feedurl='.urlencode(get_bloginfo('atom_url'));
                                    elseif (get_bloginfo('rss2_url') != null && get_bloginfo('rss2_url') != '')
										$feed_url = '&feedurl='.urlencode(get_bloginfo('rss2_url'));	
								?>
                            
                                <a href="<?php echo $page_content['tablets']['button_link'].$feed_url;?>" class="btn blue smaller" target="_blank"><?php echo $page_content['tablets']['button_text'];?></a>
                                <div class="spacer-5"></div>
                                <?php if (array_key_exists('button_subtext', $page_content['tablets'])):?>
                                    <p><?php echo $page_content['tablets']['button_subtext'];?></p>
                                <?php endif;?>
                            </div>
                            
                        <?php endif;?>
                    </div>
                    <div class="spacer-10"></div>
                    
                <?php endif;?>
                
                <?php if (array_key_exists('features', $page_content)):?>
                
                    <div class="ribbon relative">
                        <div class="indicator"></div>
                    </div> 
                    <div class="details go-premium">
                        <div class="spacer-10"></div>
                        
                        <?php if (array_key_exists('title', $page_content['features'])):?>
                            <h1><?php echo $page_content['features']['title'];?></h1>
                            <div class="spacer-60"></div>
                        <?php endif;?>
                        
                        <?php if (array_key_exists('list', $page_content['features'])): ?>
                            
                            <div class="features">
                                <?php foreach ($page_content['features']['list'] as $feature_item):?>
                                
                                    <div class="feature">
                                        <?php if (array_key_exists('image',$feature_item)):?>
                                            <img src="<?php echo $feature_item['image'];?>" />
                                            <div class="spacer-5"></div>
                                        <?php endif;?>
                                        
                                        <?php if (array_key_exists('text',$feature_item)):?>
                                            <p><?php echo $feature_item['text'];?></p>
                                        <?php endif;?>
                                        
                                    </div>
                                <?php endforeach;?>
    
                            </div>
                            <div class="spacer-60"></div>
                        <?php endif;?>
                        
                        <?php if (array_key_exists('button_text', $page_content['features']) && array_key_exists('button_link', $page_content['features'])):?>
                        
                            <div class="try-it">
                                <a href="<?php echo $page_content['features']['button_link'];?>" class="btn orange smaller" target="_blank"><?php echo $page_content['features']['button_text'];?></a>
                            </div>
                            
                        <?php endif;?>
                    </div>
                <?php endif;?>
            <?php elseif ($page_content == 'warning'):?>
            	<div class="details">
                    <div class="spacer-10"></div>
                    <div class="message-container warning">
                        <div class="wrapper">
                            <div class="title">
                                <h2 class="underlined">Can't check for updates!</h2>
                            </div>
                            <span>We are unable to display the updates on this page due to the fact that both <a href="https://php.net/manual/en/book.curl.php" target="_blank">cURL</a> and <a href="http://www.php.net/manual/en/function.fopen.php" target="_blank">fopen</a> are disabled.</span> 
                        </div>
                    </div>
                	<div class="spacer-10"></div>
                </div> 
            <?php endif;?>
        </div>
        <div class="right-side"> 
            <!-- add feedback form -->
            <?php include_once('sections/wmp-feedback.php'); ?>
        </div>
    </div>
</div>