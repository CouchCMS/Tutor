<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Gallery' order='9' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='gl01' label='GL01' _pb_template='gallery/theme/GL01' _pb_height='350'>
            <cms:embed 'pb/gallery/embed/GL01.html' />
        </cms:tile>

        <cms:tile name='gl02' label='GL02' _pb_template='gallery/theme/GL02' _pb_height='350'>
            <cms:embed 'pb/gallery/embed/GL02.html' />
        </cms:tile>

        <cms:tile name='gl03' label='GL03' _pb_template='gallery/theme/GL03' _pb_height='350'>
            <cms:embed 'pb/gallery/embed/GL03.html' />
        </cms:tile>

        <cms:tile name='gl04' label='GL04' _pb_template='gallery/theme/GL04' _pb_height='350'>
            <cms:embed 'pb/gallery/embed/GL04.html' />
        </cms:tile>

        <cms:tile name='gl05' label='GL05' _pb_template='gallery/theme/GL05' _pb_height='350'>
            <cms:embed 'pb/gallery/embed/GL05.html' />
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
