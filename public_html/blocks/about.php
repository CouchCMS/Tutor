<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='About' order='3' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='ab01' label='AB01' _pb_template='about/theme/AB01' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB01.html' />
        </cms:tile>

        <cms:tile name='ab02' label='AB02' _pb_template='about/theme/AB02' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB02.html' />
        </cms:tile>

        <cms:tile name='ab03' label='AB03' _pb_template='about/theme/AB03' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB03.html' />
        </cms:tile>

        <cms:tile name='ab04' label='AB04' _pb_template='about/theme/AB04' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB04.html' />
        </cms:tile>

        <cms:tile name='ab05' label='AB05' _pb_template='about/theme/AB05' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB05.html' />
        </cms:tile>

        <cms:tile name='ab06' label='AB06' _pb_template='about/theme/AB06' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB06.html' />
        </cms:tile>

        <cms:tile name='ab07' label='AB07' _pb_template='about/theme/AB07' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB07.html' />
        </cms:tile>

        <cms:tile name='ab08' label='AB08' _pb_template='about/theme/AB08' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB08.html' />
        </cms:tile>

        <cms:tile name='ab09' label='AB09' _pb_template='about/theme/AB09' _pb_height='350'>
            <cms:embed 'pb/about/embed/AB09.html' />
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
