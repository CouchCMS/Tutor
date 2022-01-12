<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Clients' order='8' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='cl01' label='CL01' _pb_template='clients/theme/CL01' _pb_height='350'>
            <cms:embed 'pb/clients/embed/CL01.html' />
        </cms:tile>

        <cms:tile name='cl02' label='CL02' _pb_template='clients/theme/CL02' _pb_height='350'>
            <cms:embed 'pb/clients/embed/CL02.html' />
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
