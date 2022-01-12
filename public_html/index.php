<?php require_once("couch/cms.php"); ?>
<cms:template title='Pages' order='-10003' clonable='1' nested_pages='1'>
    <cms:pagebuilder name='main_pb' label='PageBuilder' skip_custom_fields='1' order='-3'>
        <cms:section label='Covers'      name='section_covers'      masterpage='blocks/covers.php'      mosaic='blocks' tiles='' />
        <cms:section label='Intro'       name='section_intro'       masterpage='blocks/intro.php'       mosaic='blocks' tiles='' />
        <cms:section label='About'       name='section_about'       masterpage='blocks/about.php'       mosaic='blocks' tiles='' />
        <cms:section label='Details'     name='section_details'     masterpage='blocks/details.php'     mosaic='blocks' tiles='' />
        <cms:section label='Features'    name='section_features'    masterpage='blocks/features.php'    mosaic='blocks' tiles='' />
        <cms:section label='Video'       name='section_video'       masterpage='blocks/video.php'       mosaic='blocks' tiles='' />
        <cms:section label='CTA'         name='section_cta'         masterpage='blocks/cta.php'         mosaic='blocks' tiles='' />
        <cms:section label='Clients'     name='section_clients'     masterpage='blocks/clients.php'     mosaic='blocks' tiles='' />
        <cms:section label='Gallery'     name='section_gallery'     masterpage='blocks/gallery.php'     mosaic='blocks' tiles='' />
        <cms:section label='Testimonial' name='section_testimonial' masterpage='blocks/testimonials.php' mosaic='blocks' tiles='' />
        <cms:section label='Team'        name='section_team'        masterpage='blocks/team.php'        mosaic='blocks' tiles='' />
        <cms:section label='Pricing'     name='section_pricing'     masterpage='blocks/pricing.php'     mosaic='blocks' tiles='' />
        <cms:section label='FAQ'         name='section_faq'         masterpage='blocks/faq.php'         mosaic='blocks' tiles='' />
        <cms:section label='Counters'    name='section_counters'    masterpage='blocks/counters.php'    mosaic='blocks' tiles='' />
        <cms:section label='Contact'     name='section_contact'     masterpage='blocks/contact.php'     mosaic='blocks' tiles='' />
        <cms:section label='Contents'    name='section_contents'    masterpage='blocks/contents.php'    mosaic='blocks' tiles='' />
        <cms:section label='Raw HTML'    name='section_raw_html'    masterpage='blocks/raw_html.php'    mosaic='blocks' tiles='' />
    </cms:pagebuilder>

    <cms:editable name='grp_settings' type='group' label='Settings' order='1' collapsed='1'>
        <cms:editable name='row_settings' type='row' label='Settings' order='1'>
            <cms:editable name='hide_header' type='checkbox' label='Hide Header?' opt_values='Yes=yes' class='col-xs-4 col-md-2' order='1' />
            <cms:func _into='my_cond' hide_header=''>
                <cms:if "<cms:is 'yes' in=hide_header />">hide<cms:else />show</cms:if>
            </cms:func>
            <cms:editable name='header_page' label='Header' desc='select one from global headers section' type='dropdown' class='col-xs-4 col-md-4' order='2' dynamic='opt_values' opt_values='pb/misc/embed/headers_data.html' required='1' not_active=my_cond />

            <cms:editable name='hide_footer' type='checkbox' label='Hide Footer?' opt_values='Yes=yes' class='col-xs-4 col-md-2 col-break' order='3' />
            <cms:func _into='my_cond' hide_footer=''>
                <cms:if "<cms:is 'yes' in=hide_footer />">hide<cms:else />show</cms:if>
            </cms:func>
            <cms:editable name='footer_page' label='Footer' desc='select one from global footers section' type='dropdown' class='col-xs-4 col-md-4' order='4' dynamic='opt_values' opt_values='pb/misc/embed/footers_data.html' required='1' not_active=my_cond />
        </cms:editable>

        <cms:editable name='seo_settings' type='row' label='SEO' desc='overrides the global SEO settings' order='1' collapsed='1'>
            <cms:editable name='seo_noindex' type='checkbox' label='Do not index this page on search engines?' opt_values='Yes=yes' class='col-xs-4 col-md-2' order='1' />
            <cms:func _into='my_cond' seo_noindex=''>
                <cms:if "<cms:not "<cms:is 'yes' in=seo_noindex />" />">show<cms:else />hide</cms:if>
            </cms:func>
            <cms:editable name='seo_desc' label='Meta Description' type='text' class='col-xs-12 col-break' order='2' not_active=my_cond />
            <cms:editable name='seo_keywords' label='Meta Keywords' type='text' class='col-xs-12 col-break' order='2' not_active=my_cond />
        </cms:editable>

        <cms:editable name='social_settings' type='row' label='Open Graph' desc='how the page should be displayed when shared on social networks' order='2' collapsed='1'>
            <cms:editable name='social_desc' label='Description' type='text' class='col-xs-12 col-break' order='1' />
            <cms:editable name='social_image' label='Image' desc='recommended size not exceeding 500px' type='image' show_preview='1' preview_width='150' class='col-xs-12' order='2' />
        </cms:editable>
    </cms:editable>

    <cms:config_list_view exclude='default-page' />

    <cms:config_form_view>
        <cms:style>
            <cms:if k_page_name eq 'home'>
                #k_page_name, #k_publish_date, #k_nested_parent_id{ display:none; }
            </cms:if>
        </cms:style>
        <cms:script>
            $(function(){
                COUCH.el.$content.find( "#f_k_nested_parent_id option" ).filter(function(){
                    return ($(this).html()=='Default page' || $(this).html()=='- &nbsp;&nbsp;&nbsp;---divider---');
                }).hide();
            });
        </cms:script>
    </cms:config_form_view>
</cms:template>

<cms:if k_is_page>
    <cms:if k_page_name eq 'home'>
        <cms:redirect "<cms:link masterpage=k_template_name />" permanently='1' />
    </cms:if>
    <cms:embed 'pb/misc/theme/page.html' />
<cms:else />
    <cms:nested_pages root='home' depth='1' include_custom_fields='1' ignore_show_in_menu='1'>
        <cms:set my_is_home='1' />
        <cms:embed 'pb/misc/theme/page.html' />
    </cms:nested_pages>
</cms:if>
<?php COUCH::invoke(); ?>
