<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
    crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="http://localhost:35729/livereload.js?snipver=1"></script>

<script>
    //  const hash = location.hash;
    //const triggerEl = document.querySelector(hash);
    // console.log(triggerEl);
    let table = new DataTable('#dtjournal', {
        scrollX: true,
        pageLength: 100,
        ordering: false,
    });
    $(document).ready(function () {
        $('.journal-slick').slick({
            slidesToScroll: 4,
            infinite: false,
            variableWidth: true
        });
    });
    
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                console.log(`Copied text to clipboard: ${text}`);
                alert(`Copied text to clipboard: ${text}`);
            })
            .catch((error) => {
                console.error(`Could not copy text: ${error}`);
            });
    }

    document.querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach(tooltip => {
            new bootstrap.Tooltip(tooltip)
        })
</script>
</body>

</html>