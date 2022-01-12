<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Features' order='5' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='fr01' label='FR01' _pb_template='features/theme/FR01' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR01.html' />
        </cms:tile>

        <cms:tile name='fr02' label='FR02' _pb_template='features/theme/FR02' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR02.html' />
        </cms:tile>

        <cms:tile name='fr03' label='FR03' _pb_template='features/theme/FR03' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR03.html' />
        </cms:tile>

        <cms:tile name='fr04' label='FR04' _pb_template='features/theme/FR04' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR04.html' />
        </cms:tile>

        <cms:tile name='fr05' label='FR05' _pb_template='features/theme/FR05' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR05.html' />
        </cms:tile>

        <cms:tile name='fr06' label='FR06' _pb_template='features/theme/FR06' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR06.html' />
        </cms:tile>

        <cms:tile name='fr07' label='FR07' _pb_template='features/theme/FR07' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR07.html' />
        </cms:tile>

        <cms:tile name='fr08' label='FR08' _pb_template='features/theme/FR08' _pb_height='350'>
            <cms:embed 'pb/features/embed/FR08.html' />
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
