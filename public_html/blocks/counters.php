<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Counters' order='14' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='cnr01' label='CNR01' _pb_template='counters/theme/CNR01' _pb_height='350'>
            <cms:embed 'pb/counters/embed/CNR01.html' />
        </cms:tile>

        <cms:tile name='cnr02' label='CNR02' _pb_template='counters/theme/CNR02' _pb_height='350'>
            <cms:embed 'pb/counters/embed/CNR02.html' />
        </cms:tile>

        <cms:tile name='cnr03' label='CNR03' _pb_template='counters/theme/CNR03' _pb_height='350'>
            <cms:embed 'pb/counters/embed/CNR03.html' />
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
