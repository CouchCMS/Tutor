<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Video' order='6' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='vd01' label='VD01' _pb_template='video/theme/VD01' _pb_height='350'>
            <cms:embed 'pb/video/embed/VD01.html' />
        </cms:tile>

        <cms:tile name='vd02' label='VD02' _pb_template='video/theme/VD02' _pb_height='350'>
            <cms:embed 'pb/video/embed/VD02.html' />
        </cms:tile>

        <cms:tile name='vd03' label='VD03' _pb_template='video/theme/VD03' _pb_height='350'>
            <cms:embed 'pb/video/embed/VD03.html' />
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
