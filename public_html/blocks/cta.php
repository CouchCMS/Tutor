<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='CTA' order='7' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='ct01' label='CT01' _pb_template='cta/theme/CT01' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT01.html' />
        </cms:tile>

        <cms:tile name='ct02' label='CT02' _pb_template='cta/theme/CT02' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT02.html' />
        </cms:tile>

        <cms:tile name='ct03' label='CT03' _pb_template='cta/theme/CT03' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT03.html' />
        </cms:tile>

        <cms:tile name='ct04' label='CT04' _pb_template='cta/theme/CT04' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT04.html' />
        </cms:tile>

        <cms:tile name='ct05' label='CT05' _pb_template='cta/theme/CT05' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT05.html' />
        </cms:tile>

        <cms:tile name='ct06' label='CT06' _pb_template='cta/theme/CT06' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT06.html' />
        </cms:tile>

        <cms:tile name='ct07' label='CT07' _pb_template='cta/theme/CT07' _pb_height='350'>
            <cms:embed 'pb/cta/embed/CT07.html' />
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
