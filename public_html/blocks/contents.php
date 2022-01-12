<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Contents' order='16' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='tx01' label='TX01' _pb_template='contents/theme/TX01' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX01.html' />
        </cms:tile>

        <cms:tile name='tx02' label='TX02' _pb_template='contents/theme/TX02' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX02.html' />
        </cms:tile>

        <cms:tile name='tx03' label='TX03' _pb_template='contents/theme/TX03' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX03.html' />
        </cms:tile>

        <cms:tile name='tx04' label='TX04' _pb_template='contents/theme/TX04' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX04.html' />
        </cms:tile>

        <cms:tile name='tx05' label='TX05' _pb_template='contents/theme/TX05' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX05.html' />
        </cms:tile>

        <cms:tile name='tx06' label='TX06' _pb_template='contents/theme/TX06' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX06.html' />
        </cms:tile>

        <cms:tile name='tx07' label='TX07' _pb_template='contents/theme/TX07' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX07.html' />
        </cms:tile>

        <cms:tile name='tx08' label='TX08' _pb_template='contents/theme/TX08' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX08.html' />
        </cms:tile>

        <cms:tile name='tx09' label='TX09' _pb_template='contents/theme/TX09' _pb_height='350'>
            <cms:embed 'pb/contents/embed/TX09.html' />
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
