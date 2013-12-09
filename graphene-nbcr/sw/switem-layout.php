
<div class="post page">

  <?php /* Post title */ ?>
  <h2 class="post-title">
  <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permalink to %s', 'graphene'), the_title_attribute('echo=0')); ?>"><?php if (get_the_title() == '') {_e('(No title)','graphene');} else {the_title();} ?></a>
  <?php do_action('graphene_post_title'); ?> 
  </h2>

  <?php /* Post page content */ ?>
  <div class="entry-content clearfix">  
    <?php  the_post(); global $graphene_settings; global $switem_defaults;?>
    <table class="sw-item">
  
      <tr>
        <td>
          <table class="sw-desc">
          <tbody>
          <tr>
            <td class="swimg-column"><?php show_sw_img(); ?></td>
            <td rowspan="2">
              <?php show_sw_desc(); ?> 
            </td>
          </tr>
          <tr>
            <td>
              <div id="sw-itemmenu">
                <ul> <?php show_sw_links(); ?> </ul>
              </div>
            </td>
          </tr>
          </tbody>
          </table>
        </td>
      </tr>


    </table>
  </div>

</div>
