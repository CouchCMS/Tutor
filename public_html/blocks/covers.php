<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Covers' order='1' clonable='0' parent='blocks'>

    <cms:mosaic name='blocks' label='Blocks' body_class='_pb'>
        <cms:tile name='cr01' label='CR01' _pb_template='covers/theme/CR01' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR01.html' />
        </cms:tile>

        <cms:tile name='cr02' label='CR02' _pb_template='covers/theme/CR02' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR02.html' />
        </cms:tile>

        <cms:tile name='cr03' label='CR03' _pb_template='covers/theme/CR03' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR03.html' />
        </cms:tile>

        <cms:tile name='cr04' label='CR04' _pb_template='covers/theme/CR04' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR04.html' />
        </cms:tile>

        <cms:tile name='cr05' label='CR05' _pb_template='covers/theme/CR05' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR05.html' />
        </cms:tile>

        <cms:tile name='cr06' label='CR06' _pb_template='covers/theme/CR06' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR06.html' />
        </cms:tile>

        <cms:tile name='cr07' label='CR07' _pb_template='covers/theme/CR07' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR07.html' />
        </cms:tile>

        <cms:tile name='cr08' label='CR08' _pb_template='covers/theme/CR08' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR08.html' />
        </cms:tile>

        <cms:tile name='cr09' label='CR09' _pb_template='covers/theme/CR09' _pb_height='350'>
            <cms:embed 'pb/covers/embed/CR09.html' />
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
