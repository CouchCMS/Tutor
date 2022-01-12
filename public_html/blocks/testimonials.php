<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Testimonials' order='10' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='ts01' label='TS01' _pb_template='testimonials/theme/TS01' _pb_height='350'>
            <cms:embed 'pb/testimonials/embed/TS01.html' />
        </cms:tile>

        <cms:tile name='ts02' label='TS02' _pb_template='testimonials/theme/TS02' _pb_height='350'>
            <cms:embed 'pb/testimonials/embed/TS02.html' />
        </cms:tile>

        <cms:tile name='ts03' label='TS03' _pb_template='testimonials/theme/TS03' _pb_height='350'>
            <cms:embed 'pb/testimonials/embed/TS03.html' />
        </cms:tile>

        <cms:tile name='ts04' label='TS04' _pb_template='testimonials/theme/TS04' _pb_height='350'>
            <cms:embed 'pb/testimonials/embed/TS04.html' />
        </cms:tile>

        <cms:tile name='ts05' label='TS05' _pb_template='testimonials/theme/TS05' _pb_height='350'>
            <cms:embed 'pb/testimonials/embed/TS05.html' />
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
