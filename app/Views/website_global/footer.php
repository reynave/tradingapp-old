
<footer class="py-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <a href="" class="mx-1">Terms and privacy</a>
                <a href="" class="mx-1">Privacy policy</a>
                <a href="" class="mx-1"> Accessibility statement</a>
            </div>
            <div class="col-4 text-end">
                Copyright &copy;
                <?php echo date("Y"); ?>. All rights reserved.
            </div>
        </div>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="http://localhost:35729/livereload.js?snipver=1"></script>

<script>
 
    $(document).ready(function () {
        if(localStorage.getItem("app.mirrel.com") ){
            $('#singin').hide();
            $('#signed').show(); 
        } 
    });
</script>
</body>

</html>