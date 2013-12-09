
<div class="post page">

  <?php /* Post title */ ?>
  <h2 class="post-title">
  <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(esc_attr__('Permalink to %s', 'graphene'), the_title_attribute('echo=0')); ?>"><?php if (get_the_title() == '') {_e('(No title)','graphene');} else {the_title();} ?></a>
  <?php do_action('graphene_post_title'); ?> 
  </h2>

  <?php /* Post page content */ ?>
  <div class="entry-content clearfix">  
    <?php  the_post(); global $graphene_settings; global $person_defaults;?>
    <table class="person-info">
          <tr>
            <td class="person-img-column"><?php show_person_img(); ?></td>
            <td rowspan="1">
              <?php show_person_desc(); ?> 
              <div id="person-itemmenu">
                <ul> <?php show_person_links(); ?> </ul>
              </div>
            </td>
          </tr>
    </table>
  </div>

</div>
