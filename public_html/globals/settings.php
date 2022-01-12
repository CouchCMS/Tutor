<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Settings' executable='1' clonable='0' order='100' parent='_templates_'>
    <cms:editable name='settings_seo_desc' label='SEO Meta Description' type='text' order='1' />
    <cms:editable name='settings_seo_keywords' label='SEO Meta Keywords' type='text' order='2' />

</cms:template>
<cms:if k_user_access_level lt '7' >
    <cms:abort is_404='1' />
</cms:if>
<?php COUCH::invoke(); ?>
