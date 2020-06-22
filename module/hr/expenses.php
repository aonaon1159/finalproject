<form method="post" role="form">

	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid text-right">
			<a class="navbar-brand text-white">ระบบเงินเดือน - รายการหัก</a>
			<button name="saveBtn" class="btn btn-lg btn-success navbar-btn">
				<i class="fa fa-save"></i>
			</button>
			<a href="./?mod=hr/salary" class="btn btn-lg btn-warning navbar-btn">
				<i class="fa fa-remove"></i>
			</a>
		</div>
	</nav>
	
	<div class="container" style="margin-top: 80px;">
	
			<div class="row"> 
					<div class="form-group col-lg-3">
					  <label>รหัสพนักงาน :</label>
						<input type="text" 
						name="ps_id" 
						placeholder="โชว์รหัสพนักงาน" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>คำนำหน้าชื่อ :</label>
						<input type="text" 
						name="prefix_name" 
						placeholder="โชว์คำนำหน้าชื่อ" 
						Class="form-control">
					</div>
						  
					<div class="form-group col-lg-3">
					  <label>ชื่อ :</label>
						<input type="text" 
						name="ps_name" 
						placeholder="โชว์ชื่อ" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>นามสกุล :</label>
						<input type="text" 
						name="ps_surname" 
						placeholder="โชว์นามสกุล" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>ตำแหน่ง :</label>
						<input type="text" 
						name="position_name" 
						placeholder="โชว์ตำแหน่ง" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>แผนก/ฝ่าย :</label>
						<input type="text" 
						name="section_name" 
						placeholder="โชว์แผนก/ฝ่าย" 
						Class="form-control">
					</div>
					
					<div class="form-group col-lg-3">
					  <label>สาขา :</label>
						<input type="text" 
						name="branch_name" 
						placeholder="โชว์สาขา" 
						Class="form-control">
					</div>
			</div>
						
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h4>รายการหักหลัก</h4>
											
					<table class="table table-bordered">
						<thead>
							<tr class="bg-danger">
								<th class="text-center">ลำดับ</th>
								<th class="text-center">รายการ</th>
								<th class="text-center">จำนวนเงิน</th>
								<th class="text-center">จำนวนครั้งที่ชำระ</th>
						</thead>
			
						<tbody>
							<tr>
								<td>1
								<td>ประกันสังคม
								<td>000
								<td>12 <a href="./?mod=hr/expenses"><i class="fa fa-arrow-circle-down pull-right"></i></a>
						</tbody>
						
						<tbody>
							<tr>
								<td>2
								<td>เงินค้ำประกัน
								<td>000
								<td>15 <a href="./?mod=hr/expenses"><i class="fa fa-arrow-circle-down pull-right"></i></a>
						</tbody>
						
						<tbody>
							<tr>
								<td>
								<td>รวมยอดหักรายการหลัก
								<td>000
								<td>
						</tbody>
					</table>
					
				</div>
				
				<div class="col-lg-6">
					<h4>รายการหักรอง</h4>
					
					<table class="table table-bordered">
						<thead>
							<tr class="bg-danger">
								<th class="text-center">ลำดับ</th>
								<th class="text-center">รายการ</th>
								<th class="text-center">จำนวนวัน</th>
								<th class="text-center">จำนวนเงิน</th>								
						</thead>
			
						<tbody>
							<tr>
								<td>1
								<td>ลากิจ / ขาดงาน
								<td>0
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>2
								<td>ลาป่วยมีใบรับรองแพทย์  <a href="./?mod=hr/expenses"><i class="fa fa-arrow-circle-down pull-right"></i></a>
								<td>2
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>3
								<td>ลาป่วยไม่มีใบรับรองแพทย์ 
								<td>0
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>4
								<td>เงินกู้  <a href="./?mod=hr/expenses"><i class="fa fa-arrow-circle-down pull-right"></i></a>
								<td>0
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>5
								<td>เบิกเงินล่วงหน้า
								<td>0
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>6
								<td>ค่าเปอร์เซ็นต์หน้าตู้จ่ายแล้ว
								<td>0
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>7
								<td>รายการหักอื่นๆ 
								<td>0
								<td>000
						</tbody>
						
						<tbody>
							<tr>
								<td>
								<td>รวมยอดหักรายการรอง
								<td>
								<td>000
						</tbody>
					</table>
				  
				</div>
				
			</div>
		</div>		
	
		
	</div>
</form>