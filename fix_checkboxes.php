<?php
$dir = new RecursiveDirectoryIterator('C:\laragon\www\NT30\wp-content\plugins\opa-landing-engine\src');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/Settings\.php$|HomeSettings\.php$/');

foreach($files as $file) {
    $path = $file->getPathname();
    $content = file_get_contents($path);
    $original = $content;

    // HomeSettings.php static checkbox
    $content = preg_replace(
        '/<input type="checkbox" name="opa_home_settings\[enable_home\]" id="opa_enable_home" value="1" ([^>]+)>/',
        '<input type="hidden" name="opa_home_settings[enable_home]" value="0">' . "\n\t\t\t\t\t\t\t\t\t\t" . '<input type="checkbox" name="opa_home_settings[enable_home]" id="opa_enable_home" value="1" $1>',
        $content
    );

    // Component dynamic checkboxes (Hero, etc.) where ID is $args['id']
    $content = preg_replace(
        '/echo \'<input type="checkbox" id="\' \. esc_attr\( \$args\[\'id\'\] \) \. \'" name="opa_home_settings\[\' \. esc_attr\( \$args\[\'id\'\] \) \. \'\]" value="1" \' \. \$checked \. \'>\';/',
        'echo \'<input type="hidden" name="opa_home_settings[\' . esc_attr( $args[\'id\'] ) . \']" value="0">\';' . "\n\t\t" . 'echo \'<input type="checkbox" id="\' . esc_attr( $args[\'id\'] ) . \'" name="opa_home_settings[\' . esc_attr( $args[\'id\'] ) . \']" value="1" \' . $checked . \'>\';',
        $content
    );

    // Component dynamic checkboxes (FAQ, etc.) where ID is $id
    $content = preg_replace(
        '/echo \'<input type="checkbox" id="\' \. esc_attr\( \$id \) \. \'" name="opa_home_settings\[\' \. esc_attr\( \$id \) \. \'\]" value="1" \' \. \$checked \. \'>\';/',
        'echo \'<input type="hidden" name="opa_home_settings[\' . esc_attr( $id ) . \']" value="0">\';' . "\n\t\t" . 'echo \'<input type="checkbox" id="\' . esc_attr( $id ) . \'" name="opa_home_settings[\' . esc_attr( $id ) . \']" value="1" \' . $checked . \'>\';',
        $content
    );

    if ($original !== $content) {
        file_put_contents($path, $content);
        echo "Fixed $path\n";
    }
}
