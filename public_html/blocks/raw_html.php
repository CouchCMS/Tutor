<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Raw HTML' order='17' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='raw01' label='RAW01' _pb_template='raw_html/theme/RAW01' _pb_height='455'>
            <cms:embed 'pb/raw_html/embed/RAW01.html' />
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
