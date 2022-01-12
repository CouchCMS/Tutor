<?php require_once("../couch/cms.php"); ?>
<cms:template title='Uploads' order='4' clonable='0' executable='0' parent='globals'>
    <cms:editable name='upload_image' type='image' label='Image' show_preview='1' preview_width='150' order='1' />
    <cms:editable name='upload_file' type='file' label='File' order='2' />
    
    <cms:config_form_view>
        <cms:html>
            <cms:show_info heading='' >
                <a href="https://www.photopea.com/" target="_blank">Photopea Online Photo Editor</a> is recommended for editing your images before uploading.
            </cms:show_info>
        </cms:html>
        <cms:style>
            #settings-panel{ display:none; }
        </cms:style>
    </cms:config_form_view>
</cms:template>
<?php COUCH::invoke(); ?>
