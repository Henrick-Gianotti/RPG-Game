    <script>
        const BASE_URL = "<?php echo BASE_URL; ?>";
    </script>
    
    <script src="<?php echo BASE_URL; ?>/scripts/dynamic_loader.js"></script>

<?php
if (!empty($array_js))
{
    foreach($array_js as $script_path)
    {
        echo '<script src="' . BASE_URL . '/' . htmlspecialchars($script_path) . '"></script>';
    }
    
}
?>
</body>
</html>