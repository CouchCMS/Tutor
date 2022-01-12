<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Details' order='4' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='dt01' label='DT01' _pb_template='details/theme/DT01' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT01.html' />
        </cms:tile>

        <cms:tile name='dt02' label='DT02' _pb_template='details/theme/DT02' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT02.html' />
        </cms:tile>

        <cms:tile name='dt03' label='DT03' _pb_template='details/theme/DT03' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT03.html' />
        </cms:tile>

        <cms:tile name='dt04' label='DT04' _pb_template='details/theme/DT04' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT04.html' />
        </cms:tile>

        <cms:tile name='dt05' label='DT05' _pb_template='details/theme/DT05' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT05.html' />
        </cms:tile>

        <cms:tile name='dt06' label='DT06' _pb_template='details/theme/DT06' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT06.html' />
        </cms:tile>

        <cms:tile name='dt07' label='DT07' _pb_template='details/theme/DT07' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT07.html' />
        </cms:tile>

        <cms:tile name='dt08' label='DT08' _pb_template='details/theme/DT08' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT08.html' />
        </cms:tile>

        <cms:tile name='dt09' label='DT09' _pb_template='details/theme/DT09' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT09.html' />
        </cms:tile>
        
        <cms:tile name='dt10' label='DT10' _pb_template='details/theme/DT10' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT10.html' />
        </cms:tile>

        <cms:tile name='dt11' label='DT11' _pb_template='details/theme/DT11' _pb_height='350'>
            <cms:embed 'pb/details/embed/DT11.html' />
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
