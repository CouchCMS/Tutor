<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Contact' order='15' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='cnt01' label='CNT01' _pb_template='contact/theme/CNT01' _pb_height='350'>
            <cms:embed 'pb/contact/embed/CNT01.html' />
        </cms:tile>

        <cms:tile name='cnt02' label='CNT02' _pb_template='contact/theme/CNT02' _pb_height='350'>
            <cms:embed 'pb/contact/embed/CNT02.html' />
        </cms:tile>

        <cms:tile name='cnt03' label='CNT03' _pb_template='contact/theme/CNT03' _pb_height='350'>
            <cms:embed 'pb/contact/embed/CNT03.html' />
        </cms:tile>

        <cms:tile name='cnt04' label='CNT04' _pb_template='contact/theme/CNT04' _pb_height='350'>
            <cms:embed 'pb/contact/embed/CNT04.html' />
        </cms:tile>

        <cms:tile name='cnt05' label='CNT05' _pb_template='contact/theme/CNT05' _pb_height='350'>
            <cms:embed 'pb/contact/embed/CNT05.html' />
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
