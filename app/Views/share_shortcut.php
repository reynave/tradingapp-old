<div class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>
                <?= $title ?>
            </h1>
            <p>
                <?= $description ?>
            </p>
            <a href="<?= $url ?>">
                <?= $title ?>
            </a>
        </div>
        <script>
            setTimeout(()=>{
                document.location.href = "<?= $url ?>";
            }, 100);
 
        </script>
    </div>
</div>