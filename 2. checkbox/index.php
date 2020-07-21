<!doctype html>
<html lang="ko">
  <head>
  <meta charset="utf-8">
    <title>Check Box</title>
    <style>
      * {
        font-size: 16px;
        font-family: Consolas, sans-serif;
      }
    </style>
  </head>
  <body>
      <h1> form 양식 이용</h1>
      <!-- post 전송 -->
      <form name="frm" action="handler.php" method="post"> 
      <input type="checkbox" name="chkAll" onClick="javascript:checkAll();" />전체<br /> 
      <input type="checkbox" name="chk[]" id="chk" value= "KOREA" />KOREA<br />
      <input type="checkbox" name="chk[]" id="chk" value="JAPAN" />JAPAN<br />
      <input type="checkbox" name="chk[]" id="chk" value="USA" />USA<br />
      <input type="button" value="눌러" onClick="document.frm.submit();" /> </form>

      <h1> jquery 이용 </h1>

      <div id="divCheckAll">
        <input type="checkbox" name="checkall" id="checkall" onClick="check_uncheck_checkbox(this.checked);" />Check All</div>
      <div id="divCheckboxList">
	          <div class="divCheckboxItem"><input type="checkbox" name="language" id="language1" value="English" />English</div>
	          <div class="divCheckboxItem"><input type="checkbox" name="language" id="language2" value="French" />French</div>
	          <div class="divCheckboxItem"><input type="checkbox" name="language" id="language3" value="German" />German</div>
	          <div class="divCheckboxItem"><input type="checkbox" name="language" id="language4" value="Latin" />Latin</div>
      </div>

      <!-- 전체선택 메소드()-->
      <script type="text/javascript">
      function checkAll() { 
        var obj = document.frm;
        for(var i=0; i<obj.chk.length; i++) 
        { 
            obj.chk[i].checked = obj.chkAll.checked; 
        } 
      }
      </script>
      <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
      <script>
            function check_uncheck_checkbox(isChecked) {
              if(isChecked) {
                $('input[name="language"]').each(function() { 
                  this.checked = true; 
                });
              } else {
                $('input[name="language"]').each(function() {
                  this.checked = false;
                });
              }
            }
      </script>
   </body>
</html>