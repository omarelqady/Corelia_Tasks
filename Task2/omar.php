<?php
// by escaping the payload you won't break this system, haha! :-)
$escaped = preg_replace("/[`<>ux]\\/", "", $_GET['payload']);
?>

<script>
    window.addEventListener("load", function() {
        var name = `<?= $escaped ?>`;
        window.greeting.innerHTML = (name == '' ? 'こんにちは!' : name + 'さん, こんにちは!');
    });
</script>

<p id="greeting"></p>

<h1>inject</h1>
<form>
    <input type="text" name="payload" placeholder="your payload here">
    <input type="submit" value="GO">
</form>

<h1>src</h1>
<?php highlight_string(file_get_contents(basename(__FILE__))); ?>