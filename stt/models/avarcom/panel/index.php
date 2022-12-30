<form method="get">
    <input type="hidden" name="xml" value="1">
    <input type="hidden" name="sitemap" value="avar_sitemap">
    <input type="submit" value="Сгенерировать Sitemap">
</form>

<?
    $PROJECT->includeController(
        "avarcom-statistics", 
        "statistics",
        [
        ]
    );
    
?>

<div>

</div>

<?
    $PROJECT->includeController(
        "avarcom-manage", 
        "manage",
        [
        ]
    );
    
?>

<?


?>