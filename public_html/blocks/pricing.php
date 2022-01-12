<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Pricing' order='12' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='pr01' label='PR01' _pb_template='pricing/theme/PR01' _pb_height='350'>
            <cms:embed 'pb/pricing/embed/PR01.html' />
        </cms:tile>

        <cms:tile name='pr02' label='PR02' _pb_template='pricing/theme/PR02' _pb_height='350'>
            <cms:embed 'pb/pricing/embed/PR02.html' />
        </cms:tile>

        <cms:tile name='pr03' label='PR03' _pb_template='pricing/theme/PR03' _pb_height='350'>
            <cms:embed 'pb/pricing/embed/PR03.html' />
        </cms:tile>

        <cms:tile name='pr04' label='PR04' _pb_template='pricing/theme/PR04' _pb_height='350'>
            <cms:embed 'pb/pricing/embed/PR04.html' />
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
