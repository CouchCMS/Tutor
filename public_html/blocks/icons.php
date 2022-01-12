<?php require_once( '../couch/cms.php' ); ?>
<cms:template title='Icons' order='1000' clonable='0' executable='0' parent='globals'>
    <cms:editable
        name='icons'
        type='relation'
        masterpage='__icons_03efc032b9a3a1ef53981e7451e068b4.php'
        advanced_gui='1'
        has='many'
    />
    <cms:editable type='hidden' name='dummy' label='Compiler' validator='kicon::check_compile' order='300' >1</cms:editable>
</cms:template>
<cms:if k_user_access_level lt '7' >
    <cms:abort is_404='1' />
</cms:if>
<?php COUCH::invoke(); ?>
