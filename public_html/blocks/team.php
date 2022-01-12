<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Team' order='11' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='tm01' label='TM01' _pb_template='team/theme/TM01' _pb_height='350'>
            <cms:embed 'pb/team/embed/TM01.html' />
        </cms:tile>

        <cms:tile name='tm02' label='TM02' _pb_template='team/theme/TM02' _pb_height='350'>
            <cms:embed 'pb/team/embed/TM02.html' />
        </cms:tile>

        <cms:tile name='tm03' label='TM03' _pb_template='team/theme/TM03' _pb_height='350'>
            <cms:embed 'pb/team/embed/TM03.html' />
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
