<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Footer' order='25' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='ft01' label='FT01' _pb_template='footer/theme/FT01' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT01.html' />
        </cms:tile>

        <cms:tile name='ft02' label='FT02' _pb_template='footer/theme/FT02' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT02.html' />
        </cms:tile>

        <cms:tile name='ft03' label='FT03' _pb_template='footer/theme/FT03' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT03.html' />
        </cms:tile>

        <cms:tile name='ft04' label='FT04' _pb_template='footer/theme/FT04' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT04.html' />
        </cms:tile>

        <cms:tile name='ft05' label='FT05' _pb_template='footer/theme/FT05' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT05.html' />
        </cms:tile>

        <cms:tile name='ft06' label='FT06' _pb_template='footer/theme/FT06' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT06.html' />
        </cms:tile>

        <cms:tile name='ft07' label='FT07' _pb_template='footer/theme/FT07' _pb_height='350'>
            <cms:embed 'pb/footer/embed/FT07.html' />
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
