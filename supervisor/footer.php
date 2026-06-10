</div>

</div>

<script>

const menuToggle =
document.getElementById("menuToggle");

const sidebar =
document.getElementById("sidebar");

if(menuToggle){

    menuToggle.addEventListener(

        "click",

        function(){

            sidebar.classList.toggle("active");

        }

    );

}

</script>
</body>
</html>