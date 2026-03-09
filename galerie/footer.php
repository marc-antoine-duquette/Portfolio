<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('Location: index.php');
}
?>
</main>
<footer style="display: none;">
    <? //<span>Marc-Antoine Duquette | Dernière modification : 3 décembre</span> ?>
</footer>

</body>

</html>