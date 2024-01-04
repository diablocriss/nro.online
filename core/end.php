
<!-- footer -->
<footer class="mt-1">
        <br>
        <div class="text-center text-black">
          <script>
            function getYear() {
              var date = new Date();
              var year = date.getFullYear();
              document.getElementById("currentYear").innerHTML = year;
            }
          </script>
          <body onload="getYear()">
            <small>
              <b><img src="../public/images/logo/logo7.png" style="display: block; margin-left: auto; margin-right: auto; max-width:200px;"></b>
            </small>
            <small>
              <b><?=$ten_server;?></b>
            </small>
            <br>
            <small>
              <span id="currentYear"></span> © Được Vận Hành Bởi <b>
                <u>Nguyễn Huỳnh</u>
              </b>
            </small>
          </body>
        </div>
      </footer>
    </div>
  </body>		
</html>