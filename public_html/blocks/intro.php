<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Intro' order='2' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='in01' label='IN01' _pb_template='intro/theme/IN01' _pb_height='350'>
            <cms:embed 'pb/intro/embed/IN01.html' />
        </cms:tile>

        <cms:tile name='in02' label='IN02' _pb_template='intro/theme/IN02' _pb_height='350'>
            <cms:embed 'pb/intro/embed/IN02.html' />
        </cms:tile>

        <cms:tile name='in03' label='IN03' _pb_template='intro/theme/IN03' _pb_height='350'>
            <cms:embed 'pb/intro/embed/IN03.html' />
        </cms:tile>

        <cms:tile name='in04' label='IN04' _pb_template='intro/theme/IN04' _pb_height='350'>
            <cms:embed 'pb/intro/embed/IN04.html' />
        </cms:tile>

        <cms:tile name='in05' label='IN05' _pb_template='intro/theme/IN05' _pb_height='350'>
            <cms:embed 'pb/intro/embed/IN05.html' />
        </cms:tile>

        <cms:tile name='in06' label='IN06' _pb_template='intro/theme/IN06' _pb_height='350'>
            <cms:embed 'pb/intro/embed/IN06.html' />
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
