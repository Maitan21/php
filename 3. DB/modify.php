<?php

?>
<!doctype html>
<html lang="ko">
  <head>
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
        <h3 class="text-center font-weight-light my-4">회원정보수정</h3>
    </div> 
    	<div class="card-body">
            <!-- form -->
			<form id="now_modify" name="now_modify" method="post" action="now_modify_pro.jsp" onsubmit="return checkValue()">
				<input type="hidden" id="number" name="number" value="<%=number%>">
                <input type="hidden" id="birth" name="number" value="<&=birth%>">
				<input type="hidden" id="procMode" name="procMode" value=""/>
                    <!-- 이름 섹터 -->
					<div class="form-group">
                        <label class="small mb-1" for="c_id">이름</label>
						<input class="form-control py-4" id="name" name="name" type="text" value="<%=name%>"/>
					</div>
                    <!-- 주민번호 섹터 -->
                    <div class="form-group">
                        <label class="small mb-1" for="c_id">주민번호</label>
						<input class="form-control py-4" id="birth" name="birth" type="text" value="<%=birth%>"/>
					</div>

                    <!-- 전화번호 섹터 -->
					<div class="form-group">
                        <label class="small mb-1" for="c_pw">전화번호</label>
						<input class="form-control py-4" id="phone" name="phone" type="text" placeholder="ex)010-0000-0000" 
                        maxlength="13" oninput=" numberMaxLength(this);" numberOnly value="<%=phone%>"/>
					</div>

                    <!-- 방문목적 섹터 -->
					<div>
						<div class="form-group"><label class="small mb-1" for="c_type">방문목적</label>
							<select name="ips_check_flag" id="ips_check_flag" class="g2-form-control col-sm-2 fs12">
								<option value="" <%if("null".equals(now_list.get(0).getTravel())){ %>selected<%} %>></option>
								<option value="Y" <%if("Y".equals(now_list.get(0).getTravel())){ %>selected<%} %>>있음</option>
								<option value="N" <%if("N".equals(now_list.get(0).getTravel())){%>selected<%} %>>없음</option>
							</select>
						</div>

                    <!-- 수정 확인 버튼 섹터 -->
					</div>
				    <div class="row">
						<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 text-align-center">
							<button class="btn btn-primary click-login">수정</button>
						    <button class="btn btn-primary click-login" onclick="script:window.close(); return false;">취소</button>
					    </div>
				    </div>
			</form>
		</div>
			<div class="card-footer text-center">
				<div class="small">Copyright @ j-sol</div>
			</div>
		</div>
  </body>
</html>