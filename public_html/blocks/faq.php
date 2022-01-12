<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='FAQ' order='13' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='fq01' label='FQ01' _pb_template='faq/theme/FQ01' _pb_height='350'>
            <cms:embed 'pb/faq/embed/FQ01.html' />
        </cms:tile>

        <cms:tile name='fq02' label='FQ02' _pb_template='faq/theme/FQ02' _pb_height='350'>
            <cms:embed 'pb/faq/embed/FQ02.html' />
        </cms:tile>

        <cms:tile name='fq03' label='FQ03' _pb_template='faq/theme/FQ03' _pb_height='350'>
            <cms:embed 'pb/faq/embed/FQ03.html' />
        </cms:tile>
    </cms:mosaic>

</cms:template>

<cms:if k_user_access_level lt '7' >
    <cms:abort is_404='1' />
</cms:if>
        
<cms:capture into='pb_tile_content' >
    <cms:show_pagebuilder 'blocks' >
        <div class="my_wrapper">
            <cms:show k_content />
        </div>
    </cms:show_pagebuilder>
</cms:capture>
<cms:render 'pb_wrapper' 'page' />
<?php COUCH::invoke(); ?>
