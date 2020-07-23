<?php
	
?>
<!doctype html>
<html lang="ko">
  <head>
  <!-- css 로드 -->
  <link type="text/css" href ="../../resources/framework/sbAdmin/dist/css/styles.css" rerl="stylesheet"> 
  <link type="text/css" href ="../../resources/framework/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link type="text/css" href ="../../resources/framework/jQuery/ui-bootstrap/css/custom-theme/jqurey-ui-1.10.0.custom.css" rel="stylesheet">
  <link type="text/css" href ="../../resources/framework/jQuery/ui-bootstrap/assets/css/docs.css" rel="stylesheet">
  <link type="text/css" href ="../../reoucrces/framework/JQuery/ui-bootstrap/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
  <link type="text/css" href ="../../resources/css/manager_custom_css.css" rel="stylesheet">
  <link type="text/css" href ="../../resources/framework/g2minTemplate/css/site-function.css" rel="stylesheet">

  <meta charset="utf-8">
    <title>HTML</title>
    <style>
      * {
        font-size: 16px;
        font-family: Consolas, sans-serif;
      }
    </style>
  </head>
  <body class="bg-primary login-body">
<div class="card shadow-lg border-0 rounded-lg">
    <div class="card-header">
         <!-- 타이틀-->
        <h3 class="text-center font-weight-light my-4">방문자 정보수정</h3>
    </div> 
    	<div class="card-body">
            <!-- form -->
			<form id="memberModify" name="memberModify" method="post" action="_modifyFrm.php">
				<input type="hidden" id="number" name="number" value="<%=number%>">
                <input type="hidden" id="birth" name="number" value="<&=birth%>">
				<input type="hidden" id="procMode" name="procMode" value=""/>
                    <!-- 이름 섹터 -->
					<div class="form-group">
                        <label class="small mb-1">이름</label>
						<input class="form-control py-4" id="name" name="name" type="text" value="<%=name%>"/>
					</div>
                    <!-- 주민번호 섹터 -->
                    <div class="form-group">
                        <label class="small mb-1">주민번호</label>
						<input class="form-control py-4" id="birth" name="birth" type="text" value="<%=birth%>"/>
					</div>

                    <!-- 전화번호 섹터 -->
					<div class="form-group">
                        <label class="small mb-1">전화번호</label>
						<input class="form-control py-4" id="phone" name="phone" type="text" placeholder="ex)010-0000-0000" 
                        maxlength="13" oninput=" numberMaxLength(this);" numberOnly value="<%=phone%>"/>
					</div>

                    <!-- 방문목적 섹터 -->
					<div>
						<div class="form-group"><label class="small mb-1">방문유형</label>
							<select name="<?=$row["purpose"]?> id="<?=$row["purpose"]?>" class="g2-form-control col-sm-2 fs12">
							</select>
						</div>

                    <!-- 수정 확인 버튼 섹터 -->
					</div>
				
	  				<div class="row">
						<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 text-align-center">
							<button class="btn btn-primary click-login" >수정</button>
						    <button class="btn btn-primary click-login" onclick="script:window.close(); return false;">취소</button>
					    </div>
						</div>
	  				</div>
				
			</form>
		</div>
			<div class="card-footer text-center">
				<div class="small">Copyright @ j-sol</div>
			</div>
		</div>
	<script>
	</script>
  </body>
</html>