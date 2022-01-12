<?php require_once("../couch/cms.php"); ?>
<cms:template title='Footers' order='1' clonable='1' executable='1' parent='globals'>
    <cms:pagebuilder name='footers_pb' label='Footers' skip_custom_fields='1' order='-3'>
        <cms:section label='Footer'      name='section_footer'      masterpage='blocks/footer.php'      mosaic='blocks' tiles='' />
        <cms:section label='Covers'      name='section_covers'      masterpage='blocks/covers.php'      mosaic='blocks' tiles='' />
        <cms:section label='Intro'       name='section_intro'       masterpage='blocks/intro.php'       mosaic='blocks' tiles='' />
        <cms:section label='About'       name='section_about'       masterpage='blocks/about.php'       mosaic='blocks' tiles='' />
        <cms:section label='Details'     name='section_details'     masterpage='blocks/details.php'     mosaic='blocks' tiles='' />
        <cms:section label='Features'    name='section_features'    masterpage='blocks/features.php'    mosaic='blocks' tiles='' />
        <cms:section label='Video'       name='section_video'       masterpage='blocks/video.php'       mosaic='blocks' tiles='' />
        <cms:section label='CTA'         name='section_cta'         masterpage='blocks/cta.php'         mosaic='blocks' tiles='' />
        <cms:section label='Clients'     name='section_clients'     masterpage='blocks/clients.php'     mosaic='blocks' tiles='' />
        <cms:section label='Gallery'     name='section_gallery'     masterpage='blocks/gallery.php'     mosaic='blocks' tiles='' />
        <cms:section label='Testimonial' name='section_testimonial' masterpage='blocks/testimonial.php' mosaic='blocks' tiles='' />
        <cms:section label='Team'        name='section_team'        masterpage='blocks/team.php'        mosaic='blocks' tiles='' />
        <cms:section label='Pricing'     name='section_pricing'     masterpage='blocks/pricing.php'     mosaic='blocks' tiles='' />
        <cms:section label='FAQ'         name='section_faq'         masterpage='blocks/faq.php'         mosaic='blocks' tiles='' />
        <cms:section label='Counters'    name='section_counters'    masterpage='blocks/counters.php'    mosaic='blocks' tiles='' />
        <cms:section label='Contact'     name='section_contact'     masterpage='blocks/contact.php'     mosaic='blocks' tiles='' />
        <cms:section label='Raw HTML'    name='section_raw_html'    masterpage='blocks/raw_html.php'    mosaic='blocks' tiles='' />
    </cms:pagebuilder>

    <cms:config_list_view orderby='weight' order='asc' exclude='default-page'>
        <cms:field 'k_selector_checkbox' />
        <cms:field 'k_page_title' sortable='0' />
        <cms:field 'k_comments_count' />
        <cms:field 'k_page_foldertitle' />
        <cms:field 'k_up_down' />
        <cms:field 'k_actions' />
    </cms:config_list_view>
</cms:template>
<cms:if k_user_access_level lt '7' >
    <cms:abort is_404='1' />
</cms:if>

<cms:capture into='pb_tile_content' >
    <cms:show_pagebuilder 'footers_pb'>
        <cms:show k_content />
    </cms:show_pagebuilder>
</cms:capture>
<cms:render 'pb_wrapper' 'page' />

<?php COUCH::invoke(); ?>
